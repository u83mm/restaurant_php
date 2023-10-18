<form class="mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <!-- DATE AND TIME-->
    <div class="row mb-0 mb-md-3">
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="date">Fecha:</label>
            <div class="col-8 col-md-5 d-inline-block mb-2 mb-md-0">
                <input class="form-control" type="date" name="date" id="date" required>
            </div> 
        </div>
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4  orm-label mb-2 mb-md-0" for="time">Hora:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <select name="time" id="time" required>
                    <option value=""> - Selecciona -</option>
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
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="name">Nombre:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <input class="form-control" type="text" name="name" id="name" required>
            </div>        
        </div>        
        <div class="col-12 col-md-6">
            <label class="col-3 col-md-4 form-label mb-2 mb-md-0" for="qty">Personas:</label>
            <div class="col-8 col-md-7 d-inline-block mb-2 mb-md-0">
                <select name="qty" id="qty" required>
                    <option value=""> - Selecciona -</option>
                    <?php foreach ($people as $key => $value) :?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>        
    </div> 

    <!-- COMMENT -->
    <div class="row mb-0 mb-md-3">       
        <div class="col-12">
            <label class="col-2 col-md-2 form-label mb-2 mb-md-0" for="comment">Comentario:</label>
            <div class="col-12 col-md-9 d-md-inline-block">
                <textarea class="form-control" name="comment" id="comment" rows="5" placeholder="Escribe tu comentario"></textarea> 
            </div>
                   
        </div>                      
    </div> 
    
    <div class="row mb-3 mt-5   ">
        <div class="text-center">
            <button class="btn btn-outline-secondary" type="submit">Reservar</button>
        </div>           
    </div> 
</form>