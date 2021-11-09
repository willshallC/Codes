<div class="quick-search">
 <h4>Choose Alloys:</h4>
<form action="" method="get" id="search-form">
<div class="content">
<ul>
	      <li class = "fields"><label for ="aluminum">Aluminum</label><input type="checkbox" name="alloys[]" value="aluminum" name = "aluminum" id = "aluminum"></li>
		   <li class = "fields"><label for ="brass">Brass/Copper</label><input type="checkbox" name="alloys[]" value="brass_copper" name = "brass" id = "brass"></li>
		   <li class = "fields"><label for ="exotics">Exotics/Composites</label><input type="checkbox" name="alloys[]" value="exotics" name = "exotics" id = "exotics"></li>
		   <li class = "fields"><label for ="nickel">Nickel</label><input type="checkbox" name="alloys[]" value="nickel" name = "nickel" id = "nickel"></li>
		   <li class = "fields"><label for ="stainless">Stainless Steel</label><input type="checkbox" name="alloys[]" value="s_steel" name = "stainless" id = "stainless"></li>
		   <li class = "fields"><label for ="steel">Steel</label><input type="checkbox" name="alloys[]" value="steel" name = "steel" id = "steel"></li>
		   <li class = "fields"><label for ="titanium">Titanium</label><input type="checkbox" name="alloys[]" value="titanium" name = "titanium" id = "titanium"></li>

	
	
<li class="full"><button class="ibutton" id="search">Search Case Studies</button></li>
</ul>
</div>
</form>

</div>
<script>
    jQuery('#search').click(function(e) {
        e.preventDefault();

        // jQuery('.ibox2').each(function(i, obj) {
        //     if (jQuery(this).val() == null) {
        //         jQuery(this).find("option:selected").removeAttr("selected").find('option[value="all"]').attr('selected', 'selected');
        //     }
        // });
        jQuery('#search-form').submit();

    });
</script>
 

<?php if($_GET)
{
	$alloy = $_GET['alloys'];
	$alloyarray[] = array();

	   foreach($_GET['alloys'] as $value){
	      $alloyarray[] = $value;
	   }

	$filters[] = array( 'key' => 'alloys', 'value' => $alloyarray  ); 
	$args=array(
		'post_type' => 'cases',
		'posts_per_page' => 300,
		'meta_query' => $filters
	);
}
else
{
	$args=array(
		'post_type' => 'cases',
		'posts_per_page' => 300,
		'orderby' => 'title',
		'order'    => 'asc',
		'post__not_in'  => array( 292,293,295,303,315,317,319,322,323,342,344,346 )
	);	
}

query_posts($args);
?>
<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
	<div style="margin-bottom: 20px;">
						<?php $field = get_field_object('alloys'); $value = get_field('alloys'); $label = $field['choices'][ $value ];?>
		<div class="case-study-box">
				<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
				<?php the_post_thumbnail(); // Declare pixel size you need inside the array ?>
				<?php endif; ?>
	<div class="ribbon"><span><?php echo $label; ?></span></div>
		<h3 class="post-item-title color-able-blue" style="min-height: 0px; padding-top: 10px; font-size: 26px !important; text-align: center; padding-right: 30px; padding-left: 30px;"><?php the_title(); ?></h3>
					<div class="col-md-6" style="padding-right: 30px; padding-left: 30px;">
		<?php $field = get_field_object('alloys'); $value = get_field('alloys'); $label = $field['choices'][ $value ];?><h3><strong><span style="color: #f6913d";>Alloy:</span></strong> <?php echo $label; ?></h3>
		<?php $field = get_field_object('industry'); $value = get_field('industry'); $label = $field['choices'][ $value ];?><h3><strong><span style="color: #f6913d";>Industry:</span></strong> <?php echo $label; ?></h3>
		<?php if( get_field('material_removed') ): ?>
		<h3><strong><span style="color: #f6913d";>Material Removed:</span></strong> <?php the_field('material_removed'); ?></h3><?php endif; ?>
		</div>
			<div class="col-md-6" style="padding-top: 0px; padding-right: 30px; padding-left: 30px;">
		<?php if (get_field('pdf_content')): ?><?php the_field('pdf_content'); ?><?php endif; ?>

	</div>
	</div>	
	</div>
<?php endwhile; else :
?>
<p>Sorry, no case studies matching your criteria were found. Please search again using the form.</p>
<?php
 endif; ?>
<?php wp_reset_query(); ?>

</div>