<?php $userId = get_query_var('author'); ?>
<?php $user = get_userdata($userId); ?>
<h1><?php echo $user->display_name; ?><span> の投稿一覧</span></h1>
 
<?php if (!empty($user->description)) { ?>
    <p><?php echo $user->description; ?></p>
<?php } ?>
 
<?php $posts = get_posts("author=$userId&orderby=date&post_type=post&numberposts=1000"); ?>
<?php if (!empty($posts)) { ?>
    <ul> 
        <?php foreach( $posts as $post ) : setup_postdata($post); ?>
            <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> <?php echo get_the_date("Y/n/j");?></li>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </ul>
<?php } ?>
