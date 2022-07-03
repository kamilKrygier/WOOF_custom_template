# WOOF_custom_template
Custom template for displaying content between products in woocommerce loop

<hr>

There is only one file changed "woof_exts/tpl_1/views/output.php".<br>
Template was build to use with "WOOF Filters plugin" but output can be also used in default WooCommerce loop.<br>
<br>
In this code, function is pushing posts (our blog posts with some guides, etc.) between products. Also added if($product->is_in_stock()) to be sure if loop will show only in_stock products. This doesn't do anything with db query, it's just frontent "fix" (code to change it in wp_query below). It was made because of our integration with soft from which we are importing prices and stock statuses (this soft doesn't work perfect).   

```php
//Woocommerce [products] shortcode fix
//Hide out_of_stock products
function hideOutOfStockProducts( $query_args )
{
	$query_args['meta_query'] = array( array(
		'key'     => '_stock_status',
		'value'   => 'outofstock',
		'compare' => 'NOT LIKE',
	) );
    return $query_args;
}
add_filter( 'woocommerce_shortcode_products_query', 'hideOutOfStockProducts', 10, 3);
```
```php
//WOOF Filters Plugin fix
//Hide out_of_stock products
function my_woof_main_query_tax_relations($wr)
{
	//add _stock_status to meta_query 
	//REMEMBER
	//Do it using array_push... If not, filters like "price range" won't work properly
	array_push($wr['meta_query'], array(array("key"=>"_stock_status", "value"=>"outofstock", "compare"=>"NOT IN")));
	//return changed $wr
	return $wr;
}
add_filter('woof_products_query', 'my_woof_main_query_tax_relations'); 
```

Template is based  at [WOOF Filters plugin](https://products-filter.com/)