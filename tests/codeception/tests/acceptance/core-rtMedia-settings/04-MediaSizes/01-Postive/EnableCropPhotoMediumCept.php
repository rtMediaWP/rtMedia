<?php

/**
* Scenario : To set photo medium height and width when Crop is enabled.
*/

    use Page\Login as LoginPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\UploadMedia as UploadMediaPage;
    use Page\Constants as ConstantsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $scrollToDirectUpload = ConstantsPage::$masonaryCheckbox;
    $saveSession = true;

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'To set photo medium height and width when Crop is enabled.' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password, $saveSession );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$mediaSizesTab, ConstantsPage::$mediaSizesTabUrl );
    $settings->setMediaSize( ConstantsPage::$photoMediumLabel, ConstantsPage::$mediumWidthTextbox, ConstantsPage::$mediumWidth, ConstantsPage::$mediumHeightTextbox, ConstantsPage::$mediummHeight );

    $I->scrollTo( ConstantsPage::$topSaveButton );

    $settings->verifyEnableStatus( ConstantsPage::$photoThumbnailLabel, ConstantsPage::$mediumCropCheckbox );

    $I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
    $I->wait( 5 );
    $settings->verifyEnableStatus( ConstantsPage::$strMediaUploadFromActivityLabel, ConstantsPage::$mediaUploadFromActivityCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoActivityPage( ConstantsPage::$userName );

    $uploadmedia = new UploadMediaPage( $I );
    $uploadmedia->uploadMediaFromActivity( ConstantsPage::$imageName );

    echo $I->grabAttributeFrom( ConstantsPage::$thumbnailSelector, 'width' );
    echo $I->grabAttributeFrom( ConstantsPage::$thumbnailSelector, 'height' );

?>