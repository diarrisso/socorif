-- Migration script for lamaine.masingatech.com
-- Replace http://localhost:8000 with https://lamaine.masingatech.com

-- Update site URL and home URL
UPDATE wp_options SET option_value = 'https://lamaine.masingatech.com' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'https://lamaine.masingatech.com' WHERE option_name = 'home';

-- Update URLs in posts content
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8000', 'https://lamaine.masingatech.com');
UPDATE wp_posts SET post_excerpt = REPLACE(post_excerpt, 'http://localhost:8000', 'https://lamaine.masingatech.com');
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost:8000', 'https://lamaine.masingatech.com');

-- Update URLs in post meta
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8000', 'https://lamaine.masingatech.com');

-- Update URLs in options (serialized data - simple cases only)
UPDATE wp_options SET option_value = REPLACE(option_value, 'http://localhost:8000', 'https://lamaine.masingatech.com') WHERE option_name NOT IN ('siteurl', 'home');

-- Update URLs in comments
UPDATE wp_comments SET comment_content = REPLACE(comment_content, 'http://localhost:8000', 'https://lamaine.masingatech.com');
UPDATE wp_comments SET comment_author_url = REPLACE(comment_author_url, 'http://localhost:8000', 'https://lamaine.masingatech.com');

-- Update URLs in comment meta
UPDATE wp_commentmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8000', 'https://lamaine.masingatech.com');

-- Update URLs in term meta
UPDATE wp_termmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8000', 'https://lamaine.masingatech.com');

-- Update URLs in user meta
UPDATE wp_usermeta SET meta_value = REPLACE(meta_value, 'http://localhost:8000', 'https://lamaine.masingatech.com');

-- Clear any transients that might have cached URLs
DELETE FROM wp_options WHERE option_name LIKE '_transient_%';
DELETE FROM wp_options WHERE option_name LIKE '_site_transient_%';

-- Done
SELECT 'Migration completed successfully!' AS status;
