{extends file="page.tpl"}
{block name=body}
        {if $error == ""}
        <form method="GET" action="make.php">
            Project Name: <input type="text" name="projectname" value="Enter project name"/><br />
            {foreach from=$repositories item=reponame}
            <h3>Repository: {$reponame}</h3>
            <input type="hidden" name="repo[]" value="{$reponame}" />
            Branches:
            <select name="{$reponame}">
                {html_options values=$branches[$reponame] output=$branches[$reponame] selected='master'}
            </select><br /><br />
            {/foreach}
        <input type="submit" value="Generate Make File">
        </form>
        {else}
        {$error}
        {/if}
{/block}