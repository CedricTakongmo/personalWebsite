<?php
/*
# Copyright (C) 2010 - 2014 LTheme.com. All Rights Reserved.
# @license - GNU/GPL V2 or Later
# Websites: http://www.ltheme.com
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$count = count($items);
?>

<?php if( $ajaxRequest ){ ?>
	<?php if( $count>0 ){ ?>

		<?php foreach($items as $index=>$item){ ?>
			<li class="sp-portfolio-item col-<?php echo $column . ' ' . modSPPortfolioJHelper::slug($item->tag); ?>">
				<div class="sp-portfolio-item-inner">

					<div class="sp-portfolio-thumb">
						<img src="<?php echo $item->image; ?>" alt="<?php echo $item->title; ?>" />
						<div class="sp-portfolio-overlay">
							<div>
								<a class="sp-portfolio-preview" rel="lightbox" title="<?php echo $item->title; ?>" href="<?php echo $item->image_full; ?>"><i class="icon-zoom-in"></i><?php //echo JText::_('PREVIEW'); ?></a>
								<?php if($show_readmore){ ?>
									<a class="sp-portfolio-link" href="<?php echo $item->link; ?>"><i class="icon-link"></i><?php //echo JText::_('MORE_DETAILS'); ?></a>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="sp-portfolio-item-details">
						<?php if($show_title){ ?>
							<?php if($linked_title){ ?>
								<h4 class="item-title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h4>
							<?php }else { ?>
								<h4 class="item-title"><?php echo $item->title; ?></h4>
							<?php } ?>
						<?php } ?>

						<?php if(($item->urls->urla!='') && ($show_url)){ ?>
							<a href="<?php echo $item->urls->urla; ?>"><?php echo $item->urls->urlatext; ?></a>
						<?php } ?>

						<?php if($show_category){ ?>
							<small class="category-name"><?php echo $item->tag; ?></small>
						<?php } ?>		

						<?php if($show_introtext){ ?>
							<div class="sp-portfolio-introtext">
								<?php echo $item->introtext; ?>
							</div>
						<?php } ?>
					</div><!--/.sp-portfolio-item-details-->
					<div style="clear:both"></div>	
				</div><!--/.sp-portfolio-item-inner-->
			</li>
		<?php } //end foreach ?>
	<?php } ?>
	<?php jexit(); ?>
<?php } ?>
<!--/Ajax Load-->

<div id="sp-portfolio-module-<?php echo $uniqid; ?>" class="sp-portfolio default">

	<?php if($count>0){ ?>
		<?php if($show_filter){ ?>
			<ul class="sp-portfolio-filter">
				<li><a class="btn active" href="#" data-filter="*"><?php echo JText::_('Show All'); ?></a></li>
				<?php foreach (modSPPortfolioJHelper::getCategories($catid) as $key => $value) { ?>
					<li>
						<a class="btn" href="#" data-filter=".<?php echo modSPPortfolioJHelper::slug($value) ?>">
							<?php echo ucfirst(trim($value)) ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	<?php } ?>

	<?php if($count>0) { ?>
		<ul class="sp-portfolio-items">
			<?php foreach($items as $index=>$item){ ?>
				<li class="sp-portfolio-item col-<?php echo $column . ' ' . modSPPortfolioJHelper::slug($item->tag); ?> visible">
					<div class="sp-portfolio-item-inner">

						<div class="sp-portfolio-thumb">
							<img src="<?php echo $item->image; ?>" alt="<?php echo $item->title; ?>" />
							<div class="sp-portfolio-overlay">
								<div>
									<a class="sp-portfolio-preview" rel="lightbox" title="<?php echo $item->title; ?>" href="<?php echo $item->image_full; ?>"><i class="icon-zoom-in"></i><?php //echo JText::_('PREVIEW'); ?></a>
									<?php if($show_readmore){ ?>
										<a class="sp-portfolio-link" href="<?php echo $item->link; ?>"><i class="icon-link"></i><?php //echo JText::_('MORE_DETAILS'); ?></a>
									<?php } ?>
									<div class="sp-portfolio-item-details">
										<?php if($show_title){ ?>
											<?php if($linked_title){ ?>
												<h4 class="item-title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h4>
											<?php }else { ?>
												<h4 class="item-title"><?php echo $item->title; ?></h4>
											<?php } ?>
										<?php } ?>

										<?php if(($item->urls->urla!='') && ($show_url)){ ?>
											<a href="<?php echo $item->urls->urla; ?>"><?php echo $item->urls->urlatext; ?></a>
										<?php } ?>

										<?php if($show_category){ ?>
											<small class="category-name"><?php echo $item->tag; ?></small>
										<?php } ?>		

										<?php if($show_introtext){ ?>
											<div class="sp-portfolio-introtext">
												<?php echo $item->introtext; ?>
											</div>
										<?php } ?>
									</div><!--/.sp-portfolio-item-details-->
									<div style="clear:both"></div>
								</div>

							</div>
						</div>

							
					</div><!--/.sp-portfolio-item-inner-->
				</li>
			<?php } ?>
		</ul><!--/.sp-portfolio-items-->

		<?php if(($ajax_loader && $show_filter) && ($count!=$total)) { ?>
			<div class="sp-portfolio-loadmore">
				<a href="#" class="btn btn-primary btn-large">
					<i class="icon-spinner icon-spin"></i>
					<span>Load More</span>
				</a>
			</div>
		<?php } ?>

	<?php } else { ?>
		<p class="alert">No item found!</p>
	<?php } ?>
</div><!--/.sp-portfolio-->

<?php if ($show_filter){ ?>

	<script type="text/javascript">
		jQuery.noConflict();

		jQuery(function($){
			$(window).load(function(){
				var $gallery = $('.sp-portfolio-items');
				<?php if($rtl) { ?>
					// RTL Support
					$.Isotope.prototype._positionAbs = function( x, y ) {
						return { right: x, top: y };
					};
				<?php } ?>

				$gallery.isotope({
					// options
					itemSelector : 'li',
					layoutMode : 'fitRows'
					<?php if($rtl) { ?>
						,transformsEnabled: false
					<?php } ?>	
				});

				$filter = $('.sp-portfolio-filter');
				$selectors = $filter.find('>li>a');

				$filter.find('>li>a').click(function(){
					var selector = $(this).attr('data-filter');

					$selectors.removeClass('active');
					$(this).addClass('active');

					$gallery.isotope({ filter: selector });
					return false;
				});

				var $currentURL = '<?php echo  JURI::getInstance()->toString(); ?>';
				var $start = <?php echo $limit ?>;  // ajax start from last limit
				var $limit = <?php echo $ajaxlimit ?>;
				var $totalitem = <?php echo $total ?>;

				$('.sp-portfolio-loadmore > a').on('click', function(e){
					var $this = $(this);
					$this.removeClass('done').addClass('loading');
					$.get($currentURL, { moduleID: <?php echo $uniqid?>, start:$start, limit: $limit }, function(data){
						
						$start += $limit;
						var $newItems = $(data);
						$gallery.isotope( 'insert', $newItems );

						if( $totalitem <= $start ){

							$this.removeClass('loading').addClass('hide');

							// AUTOLOAD CODE BLOCK (MAY BE CHANGED OR REMOVED)
							if (!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
								jQuery(function($) {
									$("a[rel^='lightbox']").slimbox({/* Put custom options here */}, null, function(el) {
										return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
									});
								});
							}
							////
							return false;

						} else {
							$this.removeClass('loading').addClass('done');
						
							// AUTOLOAD CODE BLOCK (MAY BE CHANGED OR REMOVED)
							if (!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
								jQuery(function($) {
									$("a[rel^='lightbox']").slimbox({/* Put custom options here */}, null, function(el) {
										return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
									});
								});
							}
						}
					});

					return false;
				});
			});
		});
	</script>
<?php }