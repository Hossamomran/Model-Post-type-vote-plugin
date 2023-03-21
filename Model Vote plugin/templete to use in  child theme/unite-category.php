<?php
/* Template Name: Unite Categories */ 

get_header();
?>

<!-- Content Area -->
<main>
     <h2 class="text-center"><?php the_title(); ?></h2>
    <?php
    // Get all the categories
    $categories = get_categories();

    // Loop through each category and display its name and related posts
    foreach ( $categories as $category ) :
    ?>
    <!-- Category Name Section -->
    <section>
        <div class="container">
           
            <h3 class="text-center"><?php echo esc_html( $category->name ); ?></h3>
        </div>
    </section>

    <!-- Related Posts Section -->
    <section>
        <div class="container">
            <div class="row">
                <?php
                // Get the related posts for the current category
                $related_posts = new WP_Query( array(
                    'post_type' => 'unites',
                    'category__in' => $category->term_id,
                    'posts_per_page' => 10,
                ) );

                // Loop through each related post and display its title, thumbnail and link in a grid
                if ( $related_posts->have_posts() ) :
                    while ( $related_posts->have_posts() ) :
                        $related_posts->the_post();
                        ?>
                        <div class="col-md-4">
                            <div class="card">
                                <?php
                                global $wpdb;
                                $post_id = get_the_ID(); // Replace with the ID of the post you want to count votes for
                                $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}model_votes WHERE post_id = {$post_id}" );
                                ?>
                                <div class="card-body">
                                     <div class="card_details"><h5 class="card-title"><?php the_title(); ?> </h5>
                                     <div class="model_vote_numbers"> 
                                     <span class="model_vote_counter">   <svg viewBox="0 0 16 16" class="icon"><path fill-rule="evenodd" 
                                   clip-rule="evenodd" d="M14.999 13.999a1 1 0 11-2 0v-1c0-1.08-.15-2.018-1.861-2.547-.733.936-1.859 1.547-3.138 1.547s-2.405-.611-3.138-1.547c-1.711.529-1.861 1.467-1.861 2.547v1a1 1 0 11-2 0v-1c0-1.863.647-3.472 3.067-4.33a3.993 3.993 0 01-.067-.67V5a3.998 3.998 0 117.998 0v2.999c0 .23-.03.451-.067.67 2.42.858 3.067 2.467 3.067 4.33M10 5a2 2 0 00-4 0v2.999a2 2 0 004 0V5z">
                                   </path></svg> <?php echo $count; ?></span>
                                     </div>
                                </div>
                                    <!-- <p class="card-text"><?php //echo wp_trim_words( get_the_excerpt(), 20 ); ?></p> -->
                                    <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
                                     <?php endif; ?>
                                  
                                 <style>
                                 .card_details{
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;

                                 }   
                                 .icon{
                                       margin-right: 6px;
                                    fill: #bcc4cc;
                                    width: 12px;
                                    height: 12px;
                                 }
                                 .model_vote_counter{
                                    margin-left: 135px;
                                    /* font-size: 13px; */
                                    -webkit-box-flex: 0;
                                    -ms-flex: 0 0 auto;
                                    /* flex: 0 0 auto; */
                                    min-width: 60px;
                                    border: 1px solid transparent;
                                    color: #68707b;
                                    text-align: center;
                                    padding: 2px 3px 2px 1px;
                                    font-size: 12px;
                                    line-height: 24px;
                                    font-weight: 700;
                                    border-radius: 16px;
                                    -webkit-font-smoothing: antialiased;
                                    -moz-osx-font-smoothing: grayscale;
                                    white-space: nowrap;
                                 }
                                  </style>
                                </div>

                                <?php // Display the model_votes_form shortcode and pass the post ID to it
                                echo do_shortcode( '[model_votes_form post_id="' . get_the_ID() . '" unique_id="' . get_the_ID() . '"]' );

                                ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                endif;

                // Reset the post data
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>

    <hr>

    <?php
    endforeach;
    ?>

</main>

<!-- Footer -->
<?php get_footer(); ?>
