<div class="form-group">

    <label for="name">Name</label>
    {!! Form::text('name',null,[
    'class' => 'form-control'
 ]) !!}

 <input type="hidden" name="governorate_id" value="1">


</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit"> Create</button>
</div>
