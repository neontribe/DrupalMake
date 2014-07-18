{extends file="page.tpl"}
{block name=body}
            {if $error == ""}
            <h2>Choose branches and choose a <abbr title="If you're modifying a make file, the project name is already filled out for you.">project name</abbr>:</h2>
            <form method="GET" action="make.php" style="display:inline;">
                Project Name: <input type="text" name="projectname" value="{if $modify == "YES"}{$file_name}{else}Enter project name{/if}"/><br />
                {foreach from=$repositories item=reponame}
                <div class="box">
                    <h3>Repository: <u>{$reponame}</u></h3>
                    {if $modify == "YES"}
                    <input type="hidden" name="projectname" value="{$file_name}" />
                    {/if}
                    <input type="hidden" name="repo[]" value="{$reponame}" />
                    <input type="hidden" name="modify" value="{$modify}" />
                    Branches:
                    <select name="{$reponame}">
                        {html_options values=$branches[$reponame] output=$branches[$reponame] selected='master'}
                    </select><br /><br />
                </div>
                {/foreach}
                <button class="right">Generate Make File &rArr;</button><br />
            </form>
            <button onclick="goBack()" style="margin-top:-16.5px;">&lArr; Go back</button>
            {else}
            {$error}
            {/if}
{/block}