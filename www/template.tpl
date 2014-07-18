{extends file="page.tpl"}
{block name=body}
            {if $error == ""}
                <h2>Your new make file called "{$PROJECT_NAME}":</h2>
                <form method="POST" style="display:inline;" action="save.php">
                <input type="hidden" name="type" value="make" />
                <textarea rows="45" cols="122" name="file" style="white-space:nowrap;overflow:auto;">
core = 7.x

api = 2

projects[drupal][version] = "7.27"

projects[ctools][subdir] = "contrib"
projects[ctools][version] = "1.4"

projects[cacheexclude][subdir] = "contrib"
projects[cacheexclude][version] = "2.3"

projects[entity][subdir] = "contrib"
projects[entity][version] = "1.5"

projects[field_group][subdir] = "contrib"
projects[field_group][version] = "1.3"

projects[globalredirect][subdir] = "contrib"
projects[globalredirect][version] = "1.5"

projects[google_analytics][subdir] = "contrib"
projects[google_analytics][version] = "1.4"

projects[jquery_update][subdir] = "contrib"
projects[jquery_update][version] = "2.4"

projects[libraries][subdir] = "contrib"
projects[libraries][version] = "2.2"

projects[link][subdir] = "contrib"
projects[link][version] = "1.2"

projects[menu_block][subdir] = "contrib"
projects[menu_block][version] = "2.3"

projects[menu_expanded][subdir] = "contrib"
projects[menu_expanded][version] = "1.0-beta1"

projects[metatag][subdir] = "contrib"
projects[metatag][version] = "1.0-beta9"

projects[references][subdir] = "contrib"
projects[references][version] = "2.1"

projects[pathauto][subdir] = "contrib"
projects[pathauto][version] = "1.2"

projects[redirect][subdir] = "contrib"
projects[redirect][version] = "1.0-rc1"

projects[site_map][subdir] = "contrib"
projects[site_map][version] = "1.2"

projects[smtp][subdir] = "contrib"
projects[smtp][version] = "1.0"

projects[tagclouds][subdir] = "contrib"
projects[tagclouds][version] = "1.9"

projects[token][subdir] = "contrib"
projects[token][version] = "1.5"

projects[views][subdir] = "contrib"
projects[views][version] = "3.7"

projects[webform][subdir] = "contrib"
projects[webform][version] = "3.20"

projects[wysiwyg][subdir] = "contrib"
projects[wysiwyg][version] = "2.2"

projects[xmlsitemap][subdir] = "contrib"
projects[xmlsitemap][version] = "2.0"

{foreach from=$REPO_NAME item=reponame}
projects[{$reponame}][download][type] = "git"
projects[{$reponame}][download][url] = "git@github.com:neontribe/{$reponame}.git"
projects[{$reponame}][download][branch] = "{$REPO_BRANCH[$reponame]}"
projects[{$reponame}][subdir] = "custom"
projects[{$reponame}][type] = "{if $reponame|strstr:"_theme"}theme{elseif $reponame|strstr:"_profile"}profile{else}module{/if}"
    
{/foreach}
libraries[tabs-api-client][download][type] = "git"
libraries[tabs-api-client][download][url] = "https://ntcsdl:b191wkm@github.com/CarltonSoftware/tabs-api-client.git"
libraries[tabs-api-client][directory_name] = "tabs-api-client"
libraries[tabs-api-client][type] = "library"

libraries[ckeditor][download][type] = "file"
libraries[ckeditor][download][url] = "http://download.cksource.com/CKEditor/CKEditor/CKEditor%203.6.6.1/ckeditor_3.6.6.1.zip"
libraries[ckeditor][directory_name] = "ckeditor"
libraries[ckeditor][type] = "library"</textarea><br />
                <span style="float:right;">
                    <input type="hidden" name="new" value="YES" />
                    Project Name: <input type="text" name="name" value="{$PROJECT_NAME}" /><button class="right">Save &rArr;</button>
                    <button formaction="manifest.php" class="right">Manifest &rArr;</button>
                </span>
            </form>
            <button onclick="goBack()">&lArr; Go back</button>
            {else}
            {$error}
            {/if}
{/block}