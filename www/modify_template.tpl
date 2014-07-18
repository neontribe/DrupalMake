{extends file="page.tpl"}
{block name=body}
            {if $error == ""}
                <h2>Your modified make file called "{$PROJECT_NAME}":</h2>
                <form method="POST" style="display:inline;" action="save.php">
                <input type="hidden" name="type" value="make" />
                <textarea rows="45" cols="122" name="file" style="white-space:nowrap;overflow:auto;">
core = {$CORE}

api = {$API}
{foreach from=$REPO_NAME item=reponame}

projects[{$reponame}][download][type] = "git"
projects[{$reponame}][download][url] = "git@github.com:neontribe/{$reponame}.git"
projects[{$reponame}][download][branch] = "{$REPO_BRANCH[$reponame]}"
projects[{$reponame}][subdir] = "custom"
projects[{$reponame}][type] = "{if $reponame|strstr:"_theme"}theme{elseif $reponame|strstr:"_profile"}profile{else}module{/if}"
{/foreach}
{foreach from=$LIBRARY_NAME item=libraryname}

libraries[{$LIBRARY_NAME[$libraryname]}][download][type] = "{$LIBRARY_TYPE[$libraryname]}"
libraries[{$LIBRARY_NAME[$libraryname]}][download][url] = "{$LIBRARY_URL[$libraryname]}"
libraries[{$LIBRARY_NAME[$libraryname]}][directory_name] = "{$LIBRARY_DIR_NAME[$libraryname]}"
libraries[{$LIBRARY_NAME[$libraryname]}][type] = "library"
{/foreach}

{foreach from=$OTHER_PROJECTS item=projects}
    {$OTHER_PROJECTS[$projects]}
{/foreach}</textarea><br />
            <span style="float:right;">
                <input type="hidden" name="new" value="NO" />
                Project Name: <input type="text" name="name" value="{$PROJECT_NAME}" />
                Overrite existing file? <input type="checkbox" name="overwrite" /><button class="right">Save &rArr;</button>
                <button formaction="manifest.php" class="right">Manifest &rArr;</button>
            </span>
            </form>
            <button onclick="goBack()">&lArr; Go back</button>
            {else}
            {$error}
            {/if}
{/block}
{*{foreach from=$dd item=new}
    IT = {$new->type} 
    IT = {$new->url} 
    IT = {$new->branch} 
    IT = {$new->subdir} 
{/foreach}*}

    