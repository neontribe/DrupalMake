{extends file="page.tpl"}
{block name=body}
            <h2>List of available Neontribe repositories on Github:</h2>
            <form method="GET" action="branches.php">
                {html_checkboxes name='repo' values=$repos output=$repos separator='<br />' labels=FALSE}
                <input type="hidden" name="modify" value="NO" />
                <br />
                <button class="right">Next &rArr;</button>
            </form>
            <form method="GET" action="repos.php">
                <input type="hidden" name="update" value="true" />
                <button>Update Repo List</button>
            </form>
{/block}