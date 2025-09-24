<?php
defined( 'ABSPATH' ) || exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the current user
  UM()->user()->set();
  $user_id = UM()->user()->id;
  UM()->user()->delete();

  if ( um_user( 'after_delete' ) && um_user( 'after_delete' ) === 'redirect_home' ) {
    um_redirect_home();
  } elseif ( um_user( 'delete_redirect_url' ) ) {
    $redirect_url = apply_filters( 'um_delete_account_redirect_url', um_user( 'delete_redirect_url' ), $user_id );
    um_safe_redirect( $redirect_url );
  } else {
    um_redirect_home();
  }
}

?>
<?php if( um_user( 'can_delete_profile' ) ): ?>
<div class="account-header-wrapper">
  <section class="account-header">
    <h2>Delete Account</h2>
  </section>
  <div class="account-intro">
    <div class="page-main">
      <div class="row">
        <div
          class="col-xs-8 offset-xs-2 col-sm-4 offset-xs-0 offset-md-1 col-md-3 offset-lg-2 col-lg-2">
          <div class="avatar-image"><img
              src="<?php echo get_theme_file_uri()?>/assets/images/customer_deletion.svg" alt=""
              class="customer-avatar customer_deletion"></div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
          <div class="account-intro--main">
            <h3>Customer Deletion</h3>
            <p>We will be sorry to see you go and do respect your right to delete you account with us. If you decide to
              delete you account all your information will be deleted and anonymised where we it can not be completely
              delete for legal reasons
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="account-content-wrapper">
  <div class="content-main">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="block">
          <div class="block-content customer_deletion">
            <p class="attention-message">Please note - Once you have marked your data to be deleted or
              anonymised from our system then your data cannot be restored.
            </p>
            <form action="" method="post">
              <fieldset class="fieldset">
                <div class="actions-toolbar">
                  <div class="primary"><button type="submit" title="Delete my account" class="action save primary with-chevron-small"><span>Delete my account</span></button></div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
<div>
  <p>You do not have permission to delete your account.</p>
</div>
<?php endif; ?>