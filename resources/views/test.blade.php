<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>
   Laravel
  </title>
 </head>
 <body>


  {!! Form::open(array('url'=>'testPost','files'=>true)) !!}
  
  {!! Form::label('file','File',array('id'=>'','class'=>'')) !!}
  {!! Form::file('file','',array('id'=>'','class'=>'')) !!}
  <br/>
  <!-- submit buttons -->
  {!! Form::submit('Save') !!}
  
  <!-- reset buttons -->
  {!! Form::reset('Reset') !!}
  
  {!! Form::close() !!}
  
  
  <div class="container">
    <?php foreach ($allUsers as $user): ?>
        <?php echo $user->name; ?>
    <?php endforeach; ?>
</div>

<?php echo $allUsers->render(); ?>

 </body>
</html>

