<?php
/*
Template Name: Thesaurus Home
*/

ini_set('display_errors', '0');

global $ths_service_url, $ths_plugin_slug;

$site_language = strtolower(get_bloginfo('language'));
$lang = substr($site_language,0,2);

?>

<?php get_header(); ?>

<section class="container containerAos" id="main_container">

    <div class="padding1">

        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <div class="row">
                    <div class="col-md-12 text-center">

                        <?php
                            _e('DeCS/MeSH Tree View','ths');
                        ?>

                        <div class="treeViewDropdownLang">
                            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php _e('See in another language','ths'); ?>
                                <i class="fas fa-globe-americas"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="<?php echo pll_home_url('en').'ths/treeView'; ?>"><?php _e('English','ths'); ?></a>
                                <a class="dropdown-item" href="<?php echo pll_home_url('es').'ths/treeView'; ?>"><?php _e('Spanish','ths'); ?></a>
                                <a class="dropdown-item" href="<?php echo pll_home_url('pt').'ths/treeView'; ?>"><?php _e('Portuguese','ths'); ?></a>
                                <a class="dropdown-item" href="<?php echo pll_home_url('fr').'ths/treeView'; ?>"><?php _e('French','ths'); ?></a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <article class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm font12">

                            <ul class="listTree">
                                <li><a href="#"><?php echo choice_category('A', $lang); ?> [A]</a> <a href="#" class="btn-ajax" data-query="A??" data-ancestor="A"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('B', $lang); ?> [B]</a> <a href="#" class="btn-ajax" data-query="B??" data-ancestor="B"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('C', $lang); ?> [C]</a> <a href="#" class="btn-ajax" data-query="C??" data-ancestor="C"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('D', $lang); ?> [D]</a> <a href="#" class="btn-ajax" data-query="D??" data-ancestor="D"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('E', $lang); ?> [E]</a> <a href="#" class="btn-ajax" data-query="E??" data-ancestor="E"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('F', $lang); ?> [F]</a> <a href="#" class="btn-ajax" data-query="F??" data-ancestor="F"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('G', $lang); ?> [G]</a> <a href="#" class="btn-ajax" data-query="G??" data-ancestor="F"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('H', $lang); ?> [H]</a> <a href="#" class="btn-ajax" data-query="H?? -HP?" data-ancestor="H"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('HP', $lang); ?> [HP]</a> <a href="#" class="btn-ajax" data-query="HP?" data-ancestor="HP"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('I', $lang); ?> [I]</a> <a href="#" class="btn-ajax" data-query="I??" data-ancestor="I"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('J', $lang); ?> [J]</a> <a href="#" class="btn-ajax" data-query="J??" data-ancestor="J"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('K', $lang); ?> [K]</a> <a href="#" class="btn-ajax" data-query="K??" data-ancestor="K"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('L', $lang); ?> [L]</a> <a href="#" class="btn-ajax" data-query="L??" data-ancestor="L"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('M', $lang); ?> [M]</a> <a href="#" class="btn-ajax" data-query="M??" data-ancestor="M"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('N', $lang); ?> [N]</a> <a href="#" class="btn-ajax" data-query="N??" data-ancestor="N"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('SH', $lang); ?> [SH]</a> <a href="#" class="btn-ajax" data-query="SH?" data-ancestor="SH"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('SP', $lang); ?> [SP]</a> <a href="#" class="btn-ajax" data-query="SP?" data-ancestor="SP"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('V', $lang); ?> [V]</a> <a href="#" class="btn-ajax" data-query="V?? -VS?" data-ancestor="V"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('VS', $lang); ?> [VS]</a> <a href="#" class="btn-ajax" data-query="VS?" data-ancestor="VS"><i class="fas fa-plus-circle"></i></a></li>
                                <li><a href="#"><?php echo choice_category('Z', $lang); ?> [Z]</a> <a href="#" class="btn-ajax" data-query="Z??" data-ancestor="Z"><i class="fas fa-plus-circle"></i></a></li>
                            </ul>

                        </table>
                    </div>
                </div>
            </div>
            <br>
        </article>

    </div> 
    <div><br><br></div>
</section>

<script type="text/javascript">
    $(function () {
        $(document).on( "click", ".btn-ajax", function(e) {
            e.preventDefault();

            _this = $(this);
            _this.after('<span class="load-spinner pl-1"><?php _e('Loading...','ths'); ?> <div class="spinner-border spinner-border-sm ml-1" role="status"></div></span>');

            var ancestor = $(this).data('ancestor');
            var q = $(this).data('query');

            $.ajax({ 
                type: "POST",
                url: ths_script_vars.ajaxurl,
                data: {
                    action: 'show_tree_leaf',
                    lang: '<?php echo $lang; ?>',
                    ancestor: ancestor,
                    q: q
                },
                success: function(response){
                    tree_node = $.parseHTML( response );
                    _this.parent().after( response );
                    _this.removeClass( 'btn-ajax' ).addClass( 'btn-collapse' );
                    _this.children().removeClass( 'fa-plus-circle' ).addClass( 'fa-minus-circle' );
                    $('.load-spinner').remove();
                },
                error: function(error){ console.log(error) }
            });
        });

        $(document).on( "click", ".btn-collapse", function(e) {
            e.preventDefault();
            $(this).parent().next().toggle();
            $(this).children().toggleClass('fa-plus-circle fa-minus-circle');
        });
    });
</script>

<?php get_footer(); ?>
