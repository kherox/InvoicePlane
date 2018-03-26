<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('import_data'); ?></h1>
</div>

<div id="content">

    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><?php _trans('import_product_csv'); ?></h5>
                </div>

                <div class="panel-body">

                <?php echo form_open_multipart('products/upload');?>
                

                        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                               value="<?php echo $this->security->get_csrf_hash() ?>">

                        <div class="checkbox">
                                <label>
                                    <input type="file" name="files_content"  class="form_upload">
                                </label>
                        </div>
                        <input type="submit" class="btn btn-default" name="btn_submit"
                               value="<?php _trans('import'); ?>">

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
