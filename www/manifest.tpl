{extends file="page.tpl"}
{block name=body}
            <h2>Build "{$PROJECT_NAME}":</h2>
            <form method="POST" action="save.php" style="display:inline;">
                <input type="hidden" name="type" value="manifest" />
                <div class="box">
                    Project Name: <input type="text" name="projectname" value="{$PROJECT_NAME}">
                </div>
                <div class="box">
                    Remote URL: <input type="text" name="remoteurl" value="root@192.168.21.44">
                </div>
                <div class="box">
                    Remote Path: <input type="text" name="remotepath">
                </div>
                <div class="box">
                    Profile: <input type="text" name="profile" value="neontabs_profile">
                </div>
                <div class="box">
                    Site Name: <input type="text" name="sitename" value="{$PROJECT_NAME}">
                </div>
                <div class="box">
                    Settings Module: <input type="text" name="settingsmodule">
                </div>
                <span style="float:right;">
                    <button class="right">Save &rArr;</button>
                </span>
            </form>
            <button onclick="goBack()">&lArr; Go back</button>
{/block}