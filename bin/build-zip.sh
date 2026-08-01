#!/usr/bin/env bash
#
# Build an installable WordPress theme zip: panonfc-theme.zip
#
# The archive always contains a single top-level folder named `panonfc-theme`,
# so WordPress installs/updates it into the same slug every time — no duplicate
# themes per version, no "Destination folder already exists".
#
# Usage:
#   bin/build-zip.sh            # -> dist/panonfc-theme.zip
#   bin/build-zip.sh out.zip    # -> custom output path
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
THEME_DIR="$ROOT/panonfc-theme"
OUT="${1:-$ROOT/dist/panonfc-theme.zip}"

if [[ ! -f "$THEME_DIR/style.css" ]]; then
  echo "error: theme not found at $THEME_DIR" >&2
  exit 1
fi

VERSION="$(grep -iE '^[[:space:]]*Version:' "$THEME_DIR/style.css" | head -n1 | sed -E 's/.*Version:[[:space:]]*//' | tr -d '\r')"
echo "Packaging PANONFC theme v${VERSION}"

mkdir -p "$(dirname "$OUT")"
rm -f "$OUT"

TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT

# Copy the theme into a clean staging folder named exactly panonfc-theme.
# (Portable: no rsync dependency.)
cp -a "$THEME_DIR" "$TMP/panonfc-theme"

# Strip dev-only cruft from the staging copy.
find "$TMP/panonfc-theme" \( \
     -name '.git' -o -name '.github' -o -name 'node_modules' \
  -o -name '.DS_Store' -o -name 'Thumbs.db' -o -name '*.map' \
  \) -exec rm -rf {} + 2>/dev/null || true

( cd "$TMP" && zip -rq "$OUT" "panonfc-theme" -x '*.DS_Store' )

echo "Built: $OUT"
