<!DOCTYPE html>

<html>

    <head>

        <title>Index of <?php echo $lister->getListedShortPath(); ?></title>
        <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/img/favicon.ico">

        <!-- STYLES -->
        <link rel="stylesheet" href="<?php echo THEMEPATH; ?>/lib/bootstrap-3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo THEMEPATH; ?>/lib/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo THEMEPATH; ?>/lib/editormd/css/editormd.preview.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/css/style.css">

        <!-- SCRIPTS -->
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/jquery.min.js"></script>
        <script src="<?php echo THEMEPATH; ?>/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/js/directorylister.js"></script>
        
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/marked.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/prettify.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/raphael.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/underscore.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/flowchart.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/jquery.flowchart.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/sequence-diagram.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/lib/editormd/editormd.min.js"></script>

        <!-- FONTS -->
        <link rel="stylesheet" type="text/css"  href="<?php echo THEMEPATH; ?>/lib/css-family=Cutive+Mono.css">

        <!-- META -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">

        <?php file_exists('analytics.inc') ? include('analytics.inc') : false; ?>

    </head>

    <body>

        <div id="page-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">

				<p class="navbar-brand">File Download Station</p>

                <?php $breadcrumbs = $lister->listBreadcrumbs(); ?>

                <p class="navbar-text">
                    <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <?php if ($breadcrumb != end($breadcrumbs)): ?>
                                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                <span class="divider">/</span>
                        <?php else: ?>
                            <?php echo $breadcrumb['text']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>

                <div class="navbar-right">

                    <ul id="page-top-nav" class="nav navbar-nav">
                        <li>
                            <a href="javascript:void(0)" id="page-top-link">
                                <i class="fa fa-arrow-circle-up fa-lg"></i>
                            </a>
                        </li>
                    </ul>

                    <?php  if ($lister->isZipEnabled()): ?>
                        <ul id="page-top-download-all" class="nav navbar-nav">
                            <li>
                                <a href="?zip=<?php echo $lister->getDirectoryPath(); ?>" id="download-all-link">
                                    <i class="fa fa-download fa-lg"></i>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <div id="page-content" class="container">

            <?php file_exists('header.php') ? include('header.php') : include($lister->getThemePath(true) . "/default_header.php"); ?>

            <?php if($lister->getSystemMessages()): ?>
                <?php foreach ($lister->getSystemMessages() as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <?php echo $message['text']; ?>
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="panel panel-default table-responsive">
            	<?php if(file_exists($lister->getDirectoryPath().'/README.md')): ?>
	            	<div class="panel-body"> <div id="editormd-view"></div> </div>
	            	<script type="text/javascript">
						$(function() {
							var editormdView;
							$.get("<?php echo $lister->getDirectoryPath().'/README.md' ?>", function(markdown) {
								editormdView = editormd.markdownToHTML('editormd-view', {
									markdown:	markdown,
									htmlDecode:	"style,script,iframe",
									tocm:		true,
									emoji:		false,
									taskList:	true,
									tex:		true,
									flowChart:	true,
									sequenceDiagram:true,
								});
							});
						});
					</script>
	            <?php endif; ?>
            	<div class="table-responsive">
	            	<table class="table table-striped table-hover">
		            	<thead>
		                    <tr>
		                        <th class="col-md-8 col-sm-8 col-xs-8">文件</th>
		                        <th class="col-md-1 col-sm-1 col-xs-1 text-left">大小</th>
		                        <th class="col-md-3 col-sm-3 col-xs-3 text-left">更新时间</th>
		                    </tr>
		                </thead>
	                    <tbody>
		                    <?php foreach($dirArray as $name => $fileInfo): ?>
		                    	<tr data-name="<?php echo $name; ?>" data-href="<?php echo $fileInfo['url_path']; ?>">
			                        <td class="col-md-8 col-sm-8 col-xs-8">
			                            <span class="fa <?php echo $fileInfo['icon_class']; ?> fa-fw"></span>
			                            <a href="<?php echo $fileInfo['url_path']; ?>" data-name="<?php echo $name; ?>"><?php echo $name; ?></a></td>
			                        <td class="col-md-1 col-sm-1 col-xs-1 text-left">
			                        	<?php echo $fileInfo['file_size']; ?>
			                        </td>
			                        <td class="col-md-3 col-sm-3 col-xs-3 text-left">
			                            <?php echo $fileInfo['mod_time']; ?>
			                            <?php if (is_file($fileInfo['file_path'])): ?>
			                            	<a href="javascript:void(0)" title="Hash" class="file-info-button"><i class="fa fa-info-circle"></i></a>
			                            <?php else: ?>
			                            	<?php if ($lister->containsIndex($fileInfo['file_path'])): ?>
			                            		<a href="<?php echo $fileInfo['file_path']; ?>" class="web-link-button" <?php if($lister->externalLinksNewWindow()): ?>target="_blank"<?php endif; ?>>
			                            			<i class="fa fa-external-link"></i>
			                            		</a>
			                            	<?php endif; ?>
			                            <?php endif; ?>
			                            
			                        </td>
		                    	</tr>
		                    <?php endforeach; ?>
	            	</tbody>
	            	</table>
            	</div>
            </div>
            
        </div>

        <?php file_exists('footer.php') ? include('footer.php') : include($lister->getThemePath(true) . "/default_footer.php"); ?>

        <div id="file-info-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{modal_header}}</h4>
                    </div>

                    <div class="modal-body">

                        <table id="file-info" class="table table-bordered">
                            <tbody>

                                <tr>
                                    <td class="table-title">MD5</td>
                                    <td class="md5-hash">{{md5_sum}}</td>
                                </tr>

                                <tr>
                                    <td class="table-title">SHA1</td>
                                    <td class="sha1-hash">{{sha1_sum}}</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </body>
</html>
