<form action="/admin/admin/new" method="post">
    <div class="row mb-3">
        <label class="col-12 col-sm-3 text-center text-md-end col-form-label" for="user_name">User:</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($user_name)) echo $user_name; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-sm-3 text-center text-md-end col-form-label" for="password">Password:</label>
        <div class="col-sm-8">
            <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($password)) echo $password; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-sm-3 text-center text-md-end col-form-label" for="email">Email:</label>
        <div class="col-sm-8">
            <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>" required>
        </div>                
    </div>               
    <div class="row mb-3">
        <label class="col-12 col-sm-3 text-center text-md-end" for="nome">&nbsp;</label>
        <div class="col-sm-8 text-center text-md-start">
            <button class="btn btn-primary mb-5" type="submit" name="action" value="new"><?php echo ucfirst($home->language['send']); ?></button>        
        </div>                
    </div>                                                              
</form>