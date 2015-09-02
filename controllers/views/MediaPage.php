<?php
	require_once 'utils/StringManip.php';
	class MediaPage
	{
		private static function renderTags($id, $taglist)
		{
			$tags = implode($taglist, ' ');
			return intermix(self::$tagcode, [$id, $tags]);
		}

		private static $tagcode =
		[
			'<form action="/posttags/', '" class="row" method="post">
					<div class="cell">
						<div class="bigtext">Tags</div>
						<div class="vertical space"></div>
						<input type="submit" value="submit">
					</div>
					<div class="cell">
					</div>
					<div class="cell">
						<textarea name="tags">', '</textarea>
					</div>
				</form>
			</form>'
		];

		private static function renderDescription($id, $description)
		{
			return intermix(self::$description_code, [$id, $description]);
		}

		private static $description_code =
		[
			'<form action="/postdescription/','" class="row" method="post">
				<div class="cell">
					<div class="bigtext">Description</div>
					<div class="vertical space"></div>
					<input type="submit" value="submit">
				</div>
				<div class="cell">
				</div>
				<div class="cell">
					<textarea name="description">','</textarea>
				</div>
			</form>'
		];

		private static function renderCommentWriter($media_id)
		{
			return intermix(self::$comment_box_code, [$media_id]);
		}

		private static $comment_box_code =
		[
			'<form action="/postcomment/', '" class="row" method="post">
				<div class="cell">
					<div class="bigtext">Comment</div>
					<div class="vertical space"></div>
					<input type="submit" value="submit">
				</div>
				<div class="cell"></div>
				<div class="cell">
					<textarea name="comment" placeholder="your comment"></textarea>
				</div>
			</form>'
		];

		private static function renderComments($comment_list)
		{
			$code = '';
			foreach ($comment_list as &$comment)
				$code .= self::renderComment($comment);
			return intermix(self::$comment_code, [$code]);
		}

		static function renderComment($comment_info)
		{
			var_dump($comment_info);
			$ci = $comment_info;
			$date = $ci['comm_date'];
			$comment = $ci['comment'];
			$user = $ci['username'];
			$privilege = $ci['description']; // Privilege description
			return intermix(self::$single_comment_code, [$user, $privilege, $date, $comment]);
		}

		static private $single_comment_code =
		[
			'<div class="row">
				<div class="keep">
					<div class="cell">
						<div class="autotable">
							<div class="row">',

							'</div>
							<div class="row">
								<div class="tinytext">',

								'</div>
							</div>
							<div class="row">
								<div class="tinytext">',

								'</div>
							</div>
						</div>
					</div>
				</div>
				<div class="cell">
				</div>
				<div class="cell">
					<div class="smalltext">',

					'</div>
				</div>
			</div>
			<div class="row">
				<div class="vertical space"></div>
			</div>'
		];

		static private $comment_code =
		[
			'<div class="autotable">
				<div class="table-column auto"></div>
				<div class="table-column tiny"></div>
				<div class="table-column max"></div>',

			'</div>'
		];

		static function render($media_data, $associated_tags, $comments)
		{
			$code = '';
			if (getExtension($media_data['filename']) == 'webm')
				$code = intermix(self::$video_code, [$media_data['filename']]);
			else
				$code = intermix(self::$code, [$media_data['filename']]);
			$description = self::renderDescription($media_data['media_ID'], $media_data['description']);
			$tags = self::renderTags($media_data['media_ID'], $associated_tags);
			$comment = self::renderCommentWriter($media_data['media_ID']);
			$code .= intermix(self::$inputcode, [$description, $tags, $comment]);
			$code .= self::renderComments($comments);
			return $code;
		}

		static private $inputcode =
		[
			'<div class="autotable">
				<div class="table-column auto"></div>
				<div class="table-column tiny"></div>
				<div class="table-column max"></div>
				<div class="row"><div class="vertical space"></div></div>',
				'<div class="row"><div class="vertical space"></div></div>',
				'<div class="row"><div class="vertical space"></div></div>',
				'<div class="vertical space"></div>
			</div>'
		];

		static function renderControls($id, $user_affiliation, $stats)
		{
			if ($stats['ups'] == null)
				$stats = array('ups' => 0, 'favs' => 0, 'downs' => 0);
			if ($user_affiliation == null)
				return intermix(self::$statistics, [$id, '', $id, '', $id, '', $stats['ups'], $stats['favs'], $stats['downs']]);
			else
			{
				$ui = $user_affiliation;
				$up = $ui['upvote'] == 1 ? '&#8658; ' : '';
				$fav = $ui['favorite'] == 1 ? '&#8658; ' : '';
				$down = $ui['downvote'] == 1 ? '&#8658; ' : '';
				return intermix(self::$statistics, [$id, $up, $id, $fav, $id, $down, $stats['ups'], $stats['favs'], $stats['downs']]);
			}
		}

		static private $statistics =
		[
			'<div class="statistic smalltext table">
				<div class="row">
					<form action="/upvote/',

					'" method="post">
						<input class="upvote" type="submit" value="',

						'&#9652; Upvote">
					</form>
				</div>
				<div class="row">
					<form action="/favorite/',

					'" method="post">
						<input class="favorite" type="submit" value="',

						'&#9829; Favorite">
					</form>
				</div>
				<div class="row">
					<form action="/downvote/',

					'" method="post">
						<input class="downvote" type="submit" value="',

						'&#9662; Downvote">
					</form>
				</div>
			</div>
			<div class="vertical space"></div>
			<div class="table center">
				<div class="cell upvote"> &#9652; ',

				'</div>
				<div class="cell favorite"> &#9829; ',

				'</div>
				<div class="cell downvote"> &#9662; ',

				'</div>
			</div>'
		];

		static private $video_code =
		[
			'<video class="media" autoplay controls>
				<source src="/storage/',

				'" type="video/webm">
				<div class="warning">
					Your browser does not appear to support webm video.
				</div>
			</video>'
		];

		static private $code =
		[
			'<img class="media" src="/storage/',

			'">'
		];
	}
?>
