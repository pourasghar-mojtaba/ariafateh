<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/', true); ?></loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>

	</url>

	<url>
		<loc><?php echo __SITE_URL . "blog/blogs/last" ?></loc>
		<changefreq>daily</changefreq>
		<lastmod> <?php

			$datetime = new DateTime(date('Y-m-d h:m:s'));
			$result = $datetime->format('Y-m-d\TH:i:sP');

			echo $result;

			?></lastmod>
		<priority>0.95</priority>
	</url>

	<url>
		<loc><?php echo __SITE_URL . "pages/about" ?></loc>
		<changefreq>daily</changefreq>
		<lastmod> <?php

			$datetime = new DateTime(date('Y-m-d h:m:s'));
			$result = $datetime->format('Y-m-d\TH:i:sP');

			echo $result;

			?></lastmod>
		<priority>0.9</priority>
	</url>

	<url>
		<loc><?php echo __SITE_URL . "pages/contact_us" ?></loc>
		<changefreq>daily</changefreq>
		<lastmod><?php

			$datetime = new DateTime(date('Y-m-d h:m:s'));
			$result = $datetime->format('Y-m-d\TH:i:sP');

			echo $result;

			?></lastmod>
		<priority>0.9</priority>
	</url>

	<?php foreach ($project_categories as $project_category): ?>
		<url>
			<loc><?php echo __SITE_URL . "project/projects/index/" . $project_category['slug']; ?></loc>
			<changefreq>daily</changefreq>
			<lastmod> <?php

				$datetime = new DateTime($project_category['created']);
				$result = $datetime->format('Y-m-d\TH:i:sP');

				echo $result;

				?></lastmod>
			<priority>0.95</priority>
		</url>
	<?php endforeach; ?>

	<!-- blogs-->
	<?php foreach ($blogs as $blog): ?>
		<url>
			<loc><?php echo __SITE_URL . "blog/" . $blog['Blog']['slug']; ?></loc>
			<changefreq>daily</changefreq>
			<lastmod><?php

				$datetime = new DateTime($blog['Blog']['created']);
				$result = $datetime->format('Y-m-d\TH:i:sP');

				echo $result;

				?></lastmod>
			<priority>0.8.5</priority>
		</url>
	<?php endforeach; ?>

	<?php foreach ($projects as $project): ?>
		<url>
			<loc><?php echo __SITE_URL . "project/" . $project['Project']['slug']; ?></loc>
			<changefreq>daily</changefreq>
			<lastmod><?php

				$datetime = new DateTime($project['Project']['created']);
				$result = $datetime->format('Y-m-d\TH:i:sP');

				echo $result;

				?></lastmod>
			<priority>0.8.5</priority>
		</url>
	<?php endforeach; ?>

	<?php foreach ($blogTags as $blogTag): ?>
		<url>
			<loc><?php echo __SITE_URL . "blog/blogs/tags/" . str_replace(' ','-',$blogTag['Blogtag']['title']); ?></loc>
			<changefreq>daily</changefreq>
			<lastmod><?php

				$datetime = new DateTime($blogTag['Blogtag']['created']);
				$result = $datetime->format('Y-m-d\TH:i:sP');

				echo $result;

				?></lastmod>
			<priority>0.8</priority>
		</url>
	<?php endforeach; ?>

</urlset>
