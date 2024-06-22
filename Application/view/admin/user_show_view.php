<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = ucfirst($page->language['users']) . " | " . ucfirst($page->language['edit']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
	<h3 class="text-center"><?php echo strtoupper($page->language['user_data']); ?></h3>
    <div class="col-12 col-md-6 mx-auto">
        <?php echo $message ?? ""; ?>
        <form action="/admin/admin/update/<?php echo $user['id']; ?>" method="post">
            <input type="hidden" name="id_user" value="<?php echo $user['id']?>">
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-md-end col-form-label" for="user_name"><?php echo ucfirst($page->language['user']); ?>:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($fields['user_name'])) echo $fields['user_name']; ?>" >
                </div>                
            </div>            
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-md-end col-form-label" for="email">Email:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" >
                </div>                
            </div> 
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-md-end col-form-label" for="role">Role:</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <select name="role" id="role">
                        <option value="<?php echo $user['id_role']; ?>"><?php echo $user['role']; ?></option>
                        <?php foreach($roles as $role): ?>
                        <option value="<?php echo $role['id_role']; ?>"><?php echo $role['role']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>                
            </div>              
            <div class="row mb-3 mt-5">
                <label class="col-12 col-sm-3 text-center text-md-end" for="none">&nbsp;</label>
                <div class="col-sm-8 text-center text-md-start">
                    <button class="btn btn-outline-success" type="submit" name="action" value="update"><?php echo ucfirst($page->language['update']); ?></button>                    
                    <a class="btn btn-outline-success" href="/admin/admin/changePassword/<? echo $user['id']; ?>"><?php echo ucwords($page->language['change_password']); ?></a>
                    <a class="btn btn-outline-primary" href="/admin/admin/index"><?php echo ucfirst($page->language['go_back']); ?></a>
                </div>                
            </div>                                                              
        </form>        
    </div>    
<?php
	$page->do_html_footer();
?>