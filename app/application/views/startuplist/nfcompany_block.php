<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
	<tr>
		<td class="head">NEWLY FUNDED</td>
	</tr>
	<tr>
		<td class="content"><?php
		
		$nft = count($newlyfunded);
		if($nft){
			if($nft>5){
				$ub = 5;
			}
			else{
				$ub = $nft;
			}
			
			for($i=0; $i<$ub; $i++){
				echo "<table class='newlyfunded'>";
				echo "<tr>";
				echo "<td class='middle pad5 .nflogo'>";
				if($newlyfunded[$i]['logo']){
					echo "<a href='".site_url()."startuplist/company/".seoIze($newlyfunded[$i]['name'])."/".$newlyfunded[$i]['company_id']."' >";
					echo "<img class='rounded' src='".site_url()."media/image.php?p=".$newlyfunded[$i]['logo']."&mx=38' />";
					echo "</a>";
				}
				else{
					$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
					echo "<a href='".site_url()."startuplist/company/".seoIze($newlyfunded[$i]['name'])."/".$newlyfunded[$i]['company_id']."' >";
					echo "<img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38' />";
					echo "</a>";
				}
				echo "</td>";
				echo "<td class='middle padd5'>";
				echo "<b>".$newlyfunded[$i]['currency'].amountIze($newlyfunded[$i]['amount'])."</b> ";
				echo "<br>";
				echo "<a href='".site_url()."startuplist/company/".seoIze($newlyfunded[$i]['name'])."/".$newlyfunded[$i]['company_id']."' >".$newlyfunded[$i]['name']."</a>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
			}
			
			if($nft>5){
				echo "<div class='seeall'><a href='".site_url()."startuplist/newlyfunded'>See All ($nft)</a></div>";
			}
			
		}
		
		?></td>
	</tr>
</table>