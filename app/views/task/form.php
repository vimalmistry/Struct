<div class="row">
    <div class="col-md-6">

        <h1>New Task</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $e): ?> 
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <form class="form-horizontalx" method="POST">
            <fieldset>

                <!--<legend></legend>-->

                <div class="form-group">
                    <label class=" control-label" for="selectbasic">From</label>
                    <div class="">
                        <select id="selectbasic" name="from_user" class="form-control">
                            <option value="" >Please Select</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class=" control-label" for="selectbasic">To</label>
                    <div class="">
                        <select id="selectbasic" name="to_user" class="form-control">
                            <option value="" >Please Select</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class=" control-label" for="title">Title</label>  
                    <div class="">
                        <input id="title" name="title" type="text" placeholder="Enter Title" class="form-control input-md">

                    </div>
                </div>

                <div class="form-group">
                    <label class=" control-label" for="description">Description</label>
                    <div class="">                     
                        <textarea class="form-control" id="description" name="description" placeholder="Enter Desctription" rows="6"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class=" control-label" for="hours">Hours(Reminder)</label>
                    <div class="">
                        <select id="hours" name="hours" class="form-control">

                            <?php for ($i = 1; $i < 25; $i++): ?>
                                <option value="<?= $i ?>"><?= $i . ' Hour' ?></option>
                            <?php endfor; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group">

                    <div class="">
                        <button id="singlebutton"  class="btn btn-primary">Submit</button>

                        <button id="singlebutton"  class="btn btn-primary">Reset</button>
                    </div>
                </div>



            </fieldset>
        </form>

    </div>
</div>