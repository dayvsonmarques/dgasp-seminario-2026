#!/usr/bin/env bash
# Fix WordPress uploads directory permissions
# Usage: run from the WP root (where wp-content exists)

set -euo pipefail

WP_ROOT_DIR="$(pwd)"
UPLOADS_DIR="$WP_ROOT_DIR/wp-content/uploads"

# Detect web server user (default to m4rqu3s) or allow override via WEB_USER env
WEB_USER_DEFAULT="m4rqu3s"
WEB_GROUP_DEFAULT="m4rqu3s"

# If running on Debian/Ubuntu, www-data is common
if id www-data &>/dev/null; then
  WEB_USER_DEFAULT="www-data"
  WEB_GROUP_DEFAULT="www-data"
fi

WEB_USER="${WEB_USER:-$WEB_USER_DEFAULT}"
WEB_GROUP="${WEB_GROUP:-$WEB_GROUP_DEFAULT}"

if [ ! -d "$UPLOADS_DIR" ]; then
  echo "Creating uploads directory at $UPLOADS_DIR"
  mkdir -p "$UPLOADS_DIR"
fi

# Change owner to web server user (Debian/Ubuntu usually www-data)
# Adjust if your PHP-FPM/Apache runs under a different user.
if chown -R "$WEB_USER":"$WEB_GROUP" "$UPLOADS_DIR" 2>/dev/null; then
  echo "Owner set to $WEB_USER:$WEB_GROUP for $UPLOADS_DIR"
else
  echo "WARN: Could not change owner of $UPLOADS_DIR (permission denied)."
  echo "      Run this script with elevated privileges, e.g.:"
  echo "      sudo WEB_USER=$WEB_USER WEB_GROUP=$WEB_GROUP bash ./fix-perms.sh"
fi

# Directories: 775, Files: 664
find "$UPLOADS_DIR" -type d -exec chmod 775 {} +
find "$UPLOADS_DIR" -type f -exec chmod 664 {} +

# Ensure parent wp-content has correct perms for creation under future months
if chown "$WEB_USER":"$WEB_GROUP" "$WP_ROOT_DIR/wp-content" 2>/dev/null; then
  echo "Owner set to $WEB_USER:$WEB_GROUP for $WP_ROOT_DIR/wp-content"
else
  echo "WARN: Could not change owner of $WP_ROOT_DIR/wp-content (permission denied)."
fi
chmod 775 "$WP_ROOT_DIR/wp-content"

echo "Permissions fixed for $UPLOADS_DIR (owner: $WEB_USER:$WEB_GROUP, dirs 775, files 664)."