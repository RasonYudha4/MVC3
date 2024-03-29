<?php
$this->title = 'Profile';
?>

<h1>Contact Us</h1>

<?php $form = \app\core\form\Form::begin('', 'post'); ?>
<?php echo $form->field($model, 'subject'); ?>
<?php echo $form->field($model, 'email'); ?>
<?php echo new \app\core\form\TextareaField($model, 'body'); ?>
<?php \app\core\form\Form::end();?>
<button type="submit" class="btn btn-primary">Submit</button>