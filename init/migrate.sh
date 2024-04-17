#!/bin/bash

##############
# migrate.sh #
##############
#
# Description: 
# Updates URL in database so the site can run on localhost
#

export current_url=http://ec2-18-205-106-197.compute-1.amazonaws.com

mysql -uroot -p$MYSQL_ROOT_PASSWORD -D$MYSQL_DATABASE -e "
UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = REPLACE(option_value, '${PREV_URL}', '${current_url}') WHERE option_name = 'home' OR option_name = 'siteurl'; 
UPDATE ${WORDPRESS_TABLE_PREFIX}posts SET guid = REPLACE(guid, '${PREV_URL}', '${current_url}'); 
UPDATE ${WORDPRESS_TABLE_PREFIX}posts SET post_content = REPLACE(post_content, '${PREV_URL}', '${current_url}'); 
UPDATE ${WORDPRESS_TABLE_PREFIX}posts SET post_content = REPLACE(post_content, 'src=\"${PREV_URL}\"', 'src=\"${current_url}\"'); 
UPDATE ${WORDPRESS_TABLE_PREFIX}posts SET guid = REPLACE(guid, '${PREV_URL}', '${current_url}') WHERE post_type = 'attachment'; 
UPDATE ${WORDPRESS_TABLE_PREFIX}postmeta SET meta_value = REPLACE(meta_value, '${PREV_URL}', '${current_url}');"
