{extends file="page.tpl"}
{block name=body}
            <h2>Modifying Make File - {$file_name}</h3>
            <textarea cols='122' rows='20'>{$file_contents}</textarea>
            <form method='GET' action='branches.php'><h3>
                <h3>Neontribe Repositories Detected In Make File:</h3>
                {foreach from=$neon_projects item=reponame}
                    <div class="box">
                        <h3 style="display:inline;"><u>{$neon_projects[$reponame]}</u></h3><br />
                        <!--Detected Branch: [Display Branch Here]-->
                    </div>
                    <input type="hidden" name="file_name" value="{$file_name}" />
                    <input type="hidden" name="modify" value="YES" />
                    <input type="hidden" name="repo[]" value="{$neon_projects[$reponame]}" />
                {/foreach}
                <h3>Add more repos:</h3>
                {html_checkboxes name='repo' values=$repos output=$repos separator='<br />' labels=FALSE}
                <input type="hidden" name="libraries" value={$libraries} />
                <br /><button>Modify Branches</button>
            </form>
            <!--<form method="GET" action="read.php">
                <input type="hidden" name="update" value="true" />
                <button>Update Repo List</button>
            </form>-->
{/block}