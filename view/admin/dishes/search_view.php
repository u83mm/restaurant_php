<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>
	<h3 class="text-center">BÚSCAR PLATO</h3>
    <div class="col-12 col-lg-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <form action="#" method="post">
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="field">Campo:</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <select name="field" id="field" required>
                        <option value="">- Selecciona -</option>
                        <option value="name">Nombre</option>
                        <option value="available">Disponible</option>
                    </select>                   
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="critery">Valor:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="critery" id="critery" value="<?php if(isset($category)) echo $name; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="search">&nbsp;:</label>
                <div class="col-12 col-md-8 text-center text-sm-start">
                    <button class="btn btn-primary" name="action" value="search">Buscar</button>
                </div>                
            </div>                
        </form>
		<form action="#" method="post"><input type="submit" class="btn btn-primary mb-5" name="action" value="Volver"></form>
    </div>
<?php
	$home->do_html_footer();
?>