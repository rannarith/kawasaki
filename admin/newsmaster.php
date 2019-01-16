<?php

// news_id
// thumbnail
// title
// youtube_url
// news_date
// status

?>
<?php if ($news->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_newsmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($news->news_id->Visible) { // news_id ?>
		<tr id="r_news_id">
			<td class="col-sm-2"><?php echo $news->news_id->FldCaption() ?></td>
			<td<?php echo $news->news_id->CellAttributes() ?>>
<span id="el_news_news_id">
<span<?php echo $news->news_id->ViewAttributes() ?>>
<?php echo $news->news_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($news->_thumbnail->Visible) { // thumbnail ?>
		<tr id="r__thumbnail">
			<td class="col-sm-2"><?php echo $news->_thumbnail->FldCaption() ?></td>
			<td<?php echo $news->_thumbnail->CellAttributes() ?>>
<span id="el_news__thumbnail">
<span>
<?php echo ew_GetFileViewTag($news->_thumbnail, $news->_thumbnail->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
		<tr id="r_title">
			<td class="col-sm-2"><?php echo $news->title->FldCaption() ?></td>
			<td<?php echo $news->title->CellAttributes() ?>>
<span id="el_news_title">
<span<?php echo $news->title->ViewAttributes() ?>>
<?php echo $news->title->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($news->youtube_url->Visible) { // youtube_url ?>
		<tr id="r_youtube_url">
			<td class="col-sm-2"><?php echo $news->youtube_url->FldCaption() ?></td>
			<td<?php echo $news->youtube_url->CellAttributes() ?>>
<span id="el_news_youtube_url">
<span<?php echo $news->youtube_url->ViewAttributes() ?>>
<?php echo $news->youtube_url->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($news->news_date->Visible) { // news_date ?>
		<tr id="r_news_date">
			<td class="col-sm-2"><?php echo $news->news_date->FldCaption() ?></td>
			<td<?php echo $news->news_date->CellAttributes() ?>>
<span id="el_news_news_date">
<span<?php echo $news->news_date->ViewAttributes() ?>>
<?php echo $news->news_date->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($news->status->Visible) { // status ?>
		<tr id="r_status">
			<td class="col-sm-2"><?php echo $news->status->FldCaption() ?></td>
			<td<?php echo $news->status->CellAttributes() ?>>
<span id="el_news_status">
<span<?php echo $news->status->ViewAttributes() ?>>
<?php echo $news->status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
