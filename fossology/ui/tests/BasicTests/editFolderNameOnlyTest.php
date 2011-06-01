<?php
/***********************************************************
 Copyright (C) 2011 Hewlett-Packard Development Company, L.P.

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 version 2 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 ***********************************************************/
/**
 * edit folder name only test
 *
 * @param
 *
 * @return
 *
 * @version "$Id$"
 *
 * Created on Aug 1, 2008
 */

$where = dirname(__FILE__);
if(preg_match('!/home/jenkins.*?tests.*!', $where, $matches))
{
  //echo "running from jenkins....fossology/tests\n";
  require_once('../../tests/fossologyTestCase.php');
  require_once ('../../tests/TestEnvironment.php');
}
else
{
  //echo "using requires for running outside of jenkins\n";
  require_once('../../../tests/fossologyTestCase.php');
  require_once ('../../../tests/TestEnvironment.php');
}

global $URL;

class EditFolderNameOnlyTest extends fossologyTestCase
{
  public $folder_name;
  public $mybrowser;
  public $newname;

  function setUp()
  {
    global $URL;

    $this->Login();
    /* create a folder, which is edited below */
    $page = $this->mybrowser->get("$URL?mod=folder_create");
    $this->assertTrue($this->myassertText($page, '/Create a new Fossology folder/'));
    /* select the folder to create this folder under */
    $FolderId = $this->getFolderId('Basic-Testing', $page, 'parentid');
    $this->assertTrue($this->mybrowser->setField('parentid', $FolderId));
    $this->folder_name = 'EditOnlyMe';
    $this->assertTrue($this->mybrowser->setField('newname', $this->folder_name));
    $desc = "Folder $this->folder_name created by EditNameOnlyTest as subfolder of Testing";
    $this->assertTrue($this->mybrowser->setField('description', "$desc"));
    $page = $this->mybrowser->clickSubmit('Create!');
    $this->assertTrue($page);
    $this->assertTrue($this->myassertText($page, "/Folder $this->folder_name Created/"),
                      "FAIL! Folder $this->folder_name Created not found\n");
  }

  function testEditNameOnlyFolder()
  {
    global $URL;

    print "starting EditFolderNameOnlytest\n";
    $loggedIn = $this->mybrowser->get($URL);
    $this->assertTrue($this->myassertText($loggedIn, '/Organize/'),
                      "FAIL! Could not find Organize menu\n");
    $this->assertTrue($this->myassertText($loggedIn, '/Folders /'));
    $this->assertTrue($this->myassertText($loggedIn, '/Edit Properties/'));
    /* ok, this proves the text is on the page, let's see if we can
     * go to the page and delete a folder
     */
    $page = $this->mybrowser->get("$URL?mod=folder_properties");
    $this->assertTrue($this->myassertText($page, '/Edit Folder Properties/'));
    $FolderId = $this->getFolderId($this->folder_name, $page, 'oldfolderid');
    $this->assertTrue($FolderId);
    $this->assertTrue($this->mybrowser->setField('oldfolderid', $FolderId));
    /* edit the properties */
    $pid = getmypid();
    $this->newname = "FolderNameEditedByTest-$pid";
    $this->assertTrue($this->mybrowser->setField('newname', "$this->newname"),
                      "FAIL! Folder rename Failed\n");
    $page = $this->mybrowser->clickSubmit('Edit!');
    $this->assertTrue($page);
    $this->assertTrue($this->myassertText($page, "/Folder Properties changed/"),
                      "FAIL! Folder Properties changed not found\n");
    /* check the browse page */
    $page = $this->mybrowser->get("$URL?mod=browse");
    $this->assertTrue($this->myassertText($page, "/$this->newname/"),
                       "FAIL! Folder $this->newname not found\n");
    //print "************ page after Folder Delete! *************\n$page\n";
  }
  function tearDown()
  {
    global $URL;
    $page = $this->mybrowser->get("$URL?mod=admin_folder_delete");
    $this->assertTrue($this->myassertText($page, '/Delete Folder/'));
    $FolderId = $this->getFolderId($this->newname, $page, 'folder');
    $this->assertTrue($this->mybrowser->setField('folder', $FolderId));
    $page = $this->mybrowser->clickSubmit('Delete!');
    $this->assertTrue($page);
    $this->assertTrue($this->myassertText($page, "/Deletion of folder $this->newname/"),
                      "EditFolderOnlyTest tearDown FAILED! Deletion of $this->newname not found\n");
  }
}
?>
