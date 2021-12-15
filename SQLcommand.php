UPDATE wp_options SET option_value = replace(option_value, 'Existing URL', 'New URL') WHERE option_name = 'home' OR option_name = 'siteurl';

UPDATE wp_posts SET post_content = replace(post_content, 'Existing URL', 'New URL');

UPDATE wp_postmeta SET meta_value = replace(meta_value,'Existing URL','New URL');

UPDATE wp_usermeta SET meta_value = replace(meta_value, 'Existing URL','New URL');

UPDATE wp_links SET link_url = replace(link_url, 'Existing URL','New URL');

UPDATE wp_comments SET comment_content = replace(comment_content , 'Existing URL','New URL');