<?php

/**
* Scenario : Enable Show Album description.
*/

    use Page\Login as LoginPage;
    use Page\Constants as ConstantsPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $saveSession = true;

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'Enable Show Album description.' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password, $saveSession );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$buddypressTab, ConstantsPage::$buddypressTabUrl );

    $settings->verifyEnableStatus( ConstantsPage::$strEnableMediaInProLabel, ConstantsPage::$enableMediaInProCheckbox );
    $settings->verifyEnableStatus( ConstantsPage::$strEnableAlbumLabel, ConstantsPage::$enableAlbumCheckbox );
    $settings->verifyEnableStatus( ConstantsPage::$strShowAlbumDescLabel, ConstantsPage::$albumDescCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );

    $buddypress->createNewAlbum();
    $buddypress->editAlbumDesc();
    $buddypress->backToAlbumPage();

    $I->seeElement( ConstantsPage::$albumDescSelector );
?>