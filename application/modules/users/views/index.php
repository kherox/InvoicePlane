<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('users'); ?></h1>
<?php if ($user_types_num == 1) : ?>
    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('users/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>
<?php endif ?>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('users/index'), 'mdl_users'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><?php _trans('name'); ?></th>
                <th><?php _trans('user_type'); ?></th>
                <th><?php _trans('email_address'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php _htmlsc($user->user_name); ?></td>
                    <td><?php echo $user_types[$user->user_type]; ?></td>
                    <td><?php echo $user->user_email; ?></td>
                    <td>
                        <div class="options btn-group btn-group-sm">
                            <?php if ($user->user_type == 2) : ?>
                                <a href="<?php echo site_url('user_clients/user/' . $user->user_id); ?>"
                                   class="btn btn-default">
                                    <i class="fa fa-list fa-margin"></i> <?php _trans('assigned_clients'); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($user->user_type != 1) : ?>
                                <a class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('users/form/' . $user->user_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                            
                                        <li>
                                            <form action="<?php echo site_url('users/delete/' . $user->user_id); ?>"
                                                method="POST">
                                                <?php _csrf_field(); ?>
                                                <button type="submit" class="dropdown-button"
                                                        onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                                </button>
                                            </form>
                                        </li>
                                </ul>
                            <?php endif ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>
