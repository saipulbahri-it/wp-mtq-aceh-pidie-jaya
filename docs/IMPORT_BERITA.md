# Import Berita Dummy

This folder contains a JSON file with 10 dummy berita and a simple import script.

Files:
- `data/berita-dummy.json` - 10 dummy posts with title, date, excerpt, content, featured_image, source.
- `scripts/import-berita.php` - PHP script to import the JSON into WordPress. Place project root in WordPress installation and run.

How to run (CLI recommended):

```bash
# from project root
php scripts/import-berita.php
```

Notes:
- The script uses `wp-load.php` to bootstrap WordPress. Ensure the path in the script points to your WP root.
- Images are downloaded and sideloaded into media library; internet access required.
- The script creates a category `Berita` if not exists and assigns posts to it.
- Run only on local/dev or with proper backups on production.
