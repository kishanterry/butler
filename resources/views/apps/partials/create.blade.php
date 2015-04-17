<div class="modal fade" id="modal-add-app" tabindex="-1" role="dialog" aria-labelledby="modal-add-app-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelCreateApp()"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modal-add-app-title">Create Your App</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <p>Your can create your <strong>App</strong> here. Remember <strong>App</strong> name should be unique.</p>
                </div>
                <form ng-submit="createApp()">
                    <input name="name" ng-model="newApp.name" class="form-control" placeholder="App Name" type="text">
                    <span class="label label-danger" ng-if="createFormHasErrors"><% createFormErrors.name[0] %></span>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="createApp()">
                    <i ng-if="creating" class="fa fa-spinner fa-spin"></i>
                    Create
                </button>
                <button class="btn btn-warning" ng-click="cancelCreateApp()">Cancel</button>
            </div>
        </div>
    </div>
</div>