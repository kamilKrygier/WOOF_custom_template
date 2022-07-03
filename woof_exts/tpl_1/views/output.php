<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
global $WOOF;
if (!function_exists('get_tpl_option'))
{

    function get_tpl_option($option_key, $options)
    {
        global $WOOF;
        return $WOOF->get_option($option_key, $options[$option_key]['default']);
    }

}
defined( 'ABSPATH' ) || exit;


// Ensure visibility.
// if ( empty( $product ) || ! $product->is_visible() ) {
// 	return;
// }

//Variables
$i = 0;
$j = 0;
$six_product_category = 0;
$six_ads_category = 0;
$six_post_img;


//Check product category
switch(true)
{
    case is_product_category(143): //Pierścionki zaręczynowe
        $six_product_category = 143; //Set current products archive page category
        $six_ads_category = 1022; //Set Ads category
        break;
    case is_product_category(767): //Pierścionki zaręczynowe Vintage
        $six_product_category = 767; 
        $six_ads_category = 1022; 
        break;
    case is_product_category(766): //Pierścionki zaręczynowe Glamour
        $six_product_category = 766; 
        $six_ads_category = 1022; 
        break;
    case is_product_category(768): //Pierścionki zaręczynowe Mosaico
        $six_product_category = 768; 
        $six_ads_category = 1022; 
        break;
    case is_product_category(765): //Pierścionki zaręczynowe Inlove
        $six_product_category = 765; 
        $six_ads_category = 1022; 
        break;
    case is_product_category(233): //Biżuteria
        $six_product_category = 233; 
        $six_ads_category = 1870; 
        break;
    // default:
    // $six_ads_category = 1870; //Inne promocje (domyślna kategoria (biżuteria))

}

//Get adv posts
if($six_ads_category != 0)
{
    $args = array(
        'post_type' => 'post' ,
        'orderby' => 'date' ,
        'order' => 'DESC' ,
        'posts_per_page' => 2,
        'cat'         => $six_ads_category
      ); 
      $q = new WP_Query($args);
      if ( $q->have_posts() ) 
      { 
        while ( $q->have_posts() ) 
        {
          $q->the_post();
          $six_post_img[$j]['image'] = get_the_post_thumbnail_url(get_the_ID() , 'large');
          $six_post_img[$j]['link'] = get_post_meta( get_the_ID(), '_x_link_url',  true );
          $j++;
        }
      }
}

//Display those posts (declared above)
while ($the_products->have_posts()) : $the_products->the_post();
global $product;
if($six_ads_category != 0)
{
    if($i == 1 && !empty($six_post_img[0]))
    {
        echo do_shortcode('<li class="product six_archive_post_img" style="background-image: url('.$six_post_img[0]['image'].');"><a href="'.$six_post_img[0]['link'].'"> </a></li>');
    }
    if($i==13 && !empty($six_post_img[1]))
    {
        echo do_shortcode('<li class="product six_archive_post_img" style="background-image: url('.$six_post_img[1]['image'].');"><a href="'.$six_post_img[1]['link'].'"> </a></li>');
    }
}


//Shop loop start
if($product->is_in_stock())
{
?>
<li <?php wc_product_class( '', $product ); ?>>
    <?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
    
?>
</li>
<?php 
$i++;
}
?>
<?php endwhile; // end of the loop. ?>