
<input type="hidden" name="edit_id" value="<?php echo (!empty($data))?$data->id:0?>">
<input type="hidden" name="event_start" id="event_start">
<input type="hidden" name="event_end" id="event_end">

<div class="alert alert-danger" style="display: none;"></div>
<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Trip</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <select class="form-control" name="trip">
        <?php if (!empty($trips)){ foreach ($trips as $key => $value) { 
          echo '<option value="'. $value->id .'">'. $value->title .'</option>';
        }} ?>
      </select>
      <p class="help-block">Select trip for this date.</p>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <textarea name="description" class="form-control" placeholder="Description (optional)" rows="4"><?php echo (!empty($data))?$data->description:''?></textarea>
      <p class="help-block">Optional information about this date.</p>
    </div>
  </div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
  <div class="row">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
      <?php if ( !empty($data) ): ?>
        <div class="pull-right">
          <a href="#" class="red-color delete-event" event-id="<?php echo $data->id?>"><i class="fa fa-trash"></i> Delete</a>
        </div>
      <?php endif; ?>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

