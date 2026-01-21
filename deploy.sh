#!/bin/bash
# Socorif Deployment Script for Hostinger
# Server: lamine.masingatech.com
# Usage: Execute this script via SSH on the Hostinger server

set -e

# Configuration
DEPLOY_DIR="/home/u167262118/domains/lamine.masingatech.com/public_html"
REPO_URL="https://github.com/diarrisso/socorif.git"
BACKUP_DIR="/home/u167262118/backups"

echo "=========================================="
echo "  Socorif Deployment Script"
echo "  Target: lamine.masingatech.com"
echo "=========================================="

# Check if we're in the right directory
if [ "$(pwd)" != "$DEPLOY_DIR" ]; then
    echo "[1/5] Changing to deploy directory..."
    cd "$DEPLOY_DIR"
fi

# Create backup directory if it doesn't exist
mkdir -p "$BACKUP_DIR"

# Backup existing files if any
if [ -f "index.php" ] || [ -f "wp-config.php" ]; then
    echo "[2/5] Backing up existing files..."
    BACKUP_NAME="backup_$(date +%Y%m%d_%H%M%S).tar.gz"
    tar -czf "$BACKUP_DIR/$BACKUP_NAME" . 2>/dev/null || true
    echo "    Backup created: $BACKUP_DIR/$BACKUP_NAME"
fi

# Clear directory (except hidden files and wp-config.php)
echo "[3/5] Cleaning directory..."
find . -maxdepth 1 ! -name '.' ! -name '..' ! -name '.htaccess' ! -name 'wp-config.php' -exec rm -rf {} + 2>/dev/null || true

# Clone the repository
echo "[4/5] Cloning repository..."
git clone "$REPO_URL" temp_clone
mv temp_clone/* temp_clone/.[!.]* . 2>/dev/null || mv temp_clone/* .
rm -rf temp_clone

echo "[5/5] Setting permissions..."
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

echo ""
echo "=========================================="
echo "  Deployment Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Create database in hPanel > Databases > MySQL"
echo "2. Rename wp-config-production.php to wp-config.php"
echo "3. Edit wp-config.php with your database credentials"
echo "4. Visit https://lamine.masingatech.com/wp-admin/install.php"
echo ""
