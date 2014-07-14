{extends file="page.tpl"}
{block name=body}
        <form method="GET" action="repos.php">
            <h3>List of available Neontribe repositories on Github:</h3>
            {html_checkboxes name='repo' values=$repos[$reponame] output=$repos[$reponame] separator='<br />' labels=FALSE}
            <br />
        <input type="submit" value="Next">
        </form>
{/block}