<form class="mb-5" action="/reservations/reservation/save" method="post">

    <!-- DATE AND TIME-->
    <div class="row mb-0 mb-md-3">
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="date"><?php echo ucfirst($home->language['date']); ?>:</label>
            <div class="col-8 col-md-5 d-inline-block mb-2 mb-md-0">
                <input class="form-control blockBefore" type="date" name="date" id="date" value="<?php if(isset($fields['date'])) echo $fields['date']; ?>" required>
            </div> 
        </div>
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4  form-label mb-2 mb-md-0" for="time"><?php echo ucfirst($home->language['hour']); ?>:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <select name="time" id="time" required>
                    <option value=""> - <?php echo ucfirst($home->language['select']); ?> -</option>
                    <?php foreach ($hours as $key => $value) :?>
                    <option value="<?php echo number_format($value, 2); ?>"><?php echo number_format($value, 2); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>               
    </div> 
    
    <!-- NAME AND QTY -->
    <div class="row mb-0 mb-md-3">       
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="name"><?php echo ucfirst($home->language['name']); ?>:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <input class="form-control" type="text" name="name" id="name" value="<?php if(isset($fields['date'])) echo $fields['name']; ?>" required>
            </div>        
        </div>        
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="qty"><?php echo ucfirst($home->language['people']); ?>:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <select name="qty" id="qty" required>
                    <option value=""> - <?php echo ucfirst($home->language['select']); ?> -</option>
                    <?php foreach ($people as $key => $value) :?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>        
    </div> 

    <!-- Email -->
    <div class="row mb-0 mb-md-3">       
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="email">Email:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['date'])) echo $fields['email']; ?>" required>
            </div>        
        </div>                        
    </div> 

    <!-- COMMENT -->
    <div class="row mb-0 mb-md-3">       
        <div class="col-12">
            <label class="col-2 col-md-2 form-label mb-2 mb-md-0" for="comment"><?php echo ucfirst($home->language['comment']); ?>:</label>
            <div class="col-12 col-md-9 d-md-inline-block">
                <textarea class="form-control" name="comment" id="comment" rows="5" placeholder="<?php echo ucfirst($home->language['write_comment']); ?>"><?php if(isset($fields['comment'])) echo $fields['comment']; ?></textarea> 
            </div>
                   
        </div>                      
    </div> 
    
    <div class="row mb-3 mt-5   ">
        <div class="text-center">
            <button class="btn btn-outline-secondary" name="action" value="save" type="submit"><?php echo ucfirst($home->language['send']); ?></button>
        </div>           
    </div> 
</form>
