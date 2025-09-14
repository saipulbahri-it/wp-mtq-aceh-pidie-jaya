#!/usr/bin/env bash
set -euo pipefail

# Release automation for MTQ Aceh Pidie Jaya theme (template-only)
# - Bumps version in style.css and package.json (optional)
# - Builds CSS (npm run build)
# - Creates clean ZIP package of the theme
# - Creates git tag and GitHub Release (optional)
#
# Usage:
#   scripts/release-theme.sh <new_version> [--no-tag] [--no-release] [--dry-run]
# Examples:
#   scripts/release-theme.sh 1.0.1          # bump, build, zip, tag + release
#   scripts/release-theme.sh 1.0.1 --dry-run # show actions only
#   scripts/release-theme.sh 1.0.1 --no-release # tag only, no GH release

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")"/.. && pwd)"
THEME_DIR="wp-content/themes/mtq-aceh-pidie-jaya"
STYLE_CSS="$ROOT_DIR/$THEME_DIR/style.css"
PACKAGE_JSON="$ROOT_DIR/package.json"

NEW_VERSION="${1:-}"
[[ -z "${NEW_VERSION}" ]] && {
  echo "Usage: $0 <new_version> [--no-tag] [--no-release] [--dry-run]" >&2
  exit 1
}

NO_TAG=false
NO_RELEASE=false
DRY_RUN=false
for arg in "${@:2}"; do
  case "$arg" in
    --no-tag) NO_TAG=true ;;
    --no-release) NO_RELEASE=true ;;
    --dry-run) DRY_RUN=true ;;
    *) echo "Unknown option: $arg" >&2; exit 1 ;;
  esac
done

# Helpers
say() { echo "[release] $*"; }
run() { if $DRY_RUN; then echo "+ $*"; else eval "$*"; fi }

# 1) Verify working tree clean
if ! $DRY_RUN; then
  if [[ -n "$(git status --porcelain=v1)" ]]; then
    say "Working tree not clean. Commit or stash changes first."; exit 1
  fi
fi

# 2) Read current version from style.css
CURRENT_VERSION=$(grep -E '^Version:' "$STYLE_CSS" | awk -F': *' '{print $2}')
say "Current version: $CURRENT_VERSION -> New version: $NEW_VERSION"

# 3) Bump style.css version
run "gsed -i '' -E 's/^(Version:).*/\\1 $NEW_VERSION/' '$STYLE_CSS' || sed -i '' -E 's/^(Version:).*/\\1 $NEW_VERSION/' '$STYLE_CSS'"

# 4) Optionally bump package.json version if exists
if [[ -f "$PACKAGE_JSON" ]]; then
  run "node -e \"const fs=require('fs');const p='$PACKAGE_JSON';const j=JSON.parse(fs.readFileSync(p));j.version='$NEW_VERSION';fs.writeFileSync(p,JSON.stringify(j,null,4)+'\n');\""
fi

# 5) Build assets
run "cd '$ROOT_DIR' && npm ci && npm run build"

# 6) Create ZIP package
ZIP_NAME="mtq-aceh-pidie-jaya-theme-v$NEW_VERSION.zip"
EXCLUDES=(
  "**/.DS_Store" "**/.git*" "**/node_modules/**" "**/*.map" "**/*.log"
  "**/package.json" "**/package-lock.json" "**/postcss.config.js" "**/tailwind.config.js"
)
EXCLUDE_ARGS=""
for e in "${EXCLUDES[@]}"; do EXCLUDE_ARGS+=" -x '$e'"; done
run "cd '$ROOT_DIR' && rm -f '$ZIP_NAME' && zip -r '$ZIP_NAME' '$THEME_DIR' $EXCLUDE_ARGS"

# 7) Commit bump
run "cd '$ROOT_DIR' && git add '$STYLE_CSS' '$PACKAGE_JSON' && git commit -m 'chore(release): bump theme version to v$NEW_VERSION'"

# 8) Tag and push
if ! $NO_TAG; then
  run "cd '$ROOT_DIR' && git tag -a v$NEW_VERSION -m 'MTQ Aceh Pidie Jaya Theme v$NEW_VERSION'"
  run "cd '$ROOT_DIR' && git push origin main && git push origin v$NEW_VERSION"
fi

# 9) Create GitHub Release
if ! $NO_RELEASE; then
  run "cd '$ROOT_DIR' && gh release create v$NEW_VERSION -t 'MTQ Aceh Pidie Jaya Theme v$NEW_VERSION' -F RELEASE_NOTES.md '$ZIP_NAME'"
fi

say "Done. Artifact: $ZIP_NAME"
