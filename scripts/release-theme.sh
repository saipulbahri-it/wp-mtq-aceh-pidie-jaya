#!/usr/bin/env bash
set -euo pipefail

# Usage:
#   bash scripts/release-theme.sh zip           # build + zip only
#   bash scripts/release-theme.sh release       # build + zip + tag + GitHub release
# Env overrides:
#   VERSION=1.0.1 (optional; falls back to package.json version)
#   TAG_PREFIX=v (default "v")
#   THEME_PATH=wp-content/themes/mtq-aceh-pidie-jaya

MODE="${1:-zip}"
TAG_PREFIX="${TAG_PREFIX:-v}"
THEME_PATH="${THEME_PATH:-wp-content/themes/mtq-aceh-pidie-jaya}"

# Read version from env or package.json
if [[ -n "${VERSION:-}" ]]; then
  VERSION_STR="$VERSION"
else
  VERSION_STR=$(node -p "require('./package.json').version")
fi

ZIP_NAME="mtq-aceh-pidie-jaya-theme-${VERSION_STR}.zip"
TAG_NAME="${TAG_PREFIX}${VERSION_STR}"

# 1) Build assets
npm run build

# 2) Ensure dist exists
if [[ ! -f "${THEME_PATH}/dist/app.css" ]]; then
  echo "Error: ${THEME_PATH}/dist/app.css not found after build" >&2
  exit 1
fi

# 3) Zip theme (exclude dev files)
rm -f "$ZIP_NAME"
zip -r "$ZIP_NAME" "$THEME_PATH" \
  -x "**/.DS_Store" "**/.git*" "**/node_modules/**" \
     "**/package.json" "**/package-lock.json" \
     "**/postcss.config.js" "**/tailwind.config.js" \
     "**/assets/css/**" "**/*.map" "**/*.log"

if [[ "$MODE" == "zip" ]]; then
  echo "Created ZIP: $ZIP_NAME"
  exit 0
fi

# 4) Tag & GitHub Release
if [[ "$MODE" == "release" ]]; then
  # Create tag if not exists
  if git rev-parse "$TAG_NAME" >/dev/null 2>&1; then
    echo "Tag $TAG_NAME already exists. Skipping tag creation."
  else
    git tag -a "$TAG_NAME" -m "Release $TAG_NAME"
    git push origin "$TAG_NAME"
  fi

  # Create GitHub release and upload asset
  if gh release view "$TAG_NAME" >/dev/null 2>&1; then
    echo "GitHub Release $TAG_NAME exists. Uploading asset..."
    gh release upload "$TAG_NAME" "$ZIP_NAME" --clobber
  else
    NOTES_FILE="RELEASE_NOTES.md"
    TITLE="MTQ Aceh Pidie Jaya Theme ${TAG_NAME}"
    gh release create "$TAG_NAME" -F "$NOTES_FILE" -t "$TITLE" "$ZIP_NAME"
  fi
  echo "Release completed: $TAG_NAME"
fi
