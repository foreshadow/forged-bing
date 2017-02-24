<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
        <h4 class="modal-title">New Agenda</h4>
      </div>
      <form class="form" action="/calendar" method="post">
        <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" class="form-control">
          </div>
          <div class="form-group">
            <label>Begin at</label>
            <input type="datetime-local" name="begin_at" class="form-control" required>
          </div>
          <div class="form-group">
            <label>End at</label>
            <input type="datetime-local" name="end_at" class="form-control">
          </div>
          <div class="form-group">
            <label>Repeat</label>
            <div class="form-inline">
              Every
              <input type="text" name="repeat_interval" class="form-control" value="">
              days for
              <input type="text" name="repeat_time" class="form-control" value="">
              times
            </div>
          </div>
          <div class="form-group">
            <label>CSS Class</label>
            <input type="text" name="class" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
