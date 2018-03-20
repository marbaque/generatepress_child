<?php
/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
?>
		<?php 
		
		$term = get_field('tipo_recurso');
		
		if( $term && $term->slug == 'video-educativo' ): ?>
		<div class="video-wrap">
			<div class="video-dark-background" aria-hidden></div>
			<div class="video-contenedor">
				<?php 
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
					the_post_thumbnail('portada-video');
				} 
				?>
			</div>
		</div>
		<?php 
		elseif( $term && $term->slug == 'modelo-3d' ): ?>
		<div class="3d-wrap">
			<div id="3d-contenedor">
				<?php 
				if ( has_post_video() ) { ?>

				<input type="hidden" id="stl-uri" value="<?php echo get_the_post_video_url(); ?>">

				<!-- STL viewer based on https://github.com/tonylukasavage/jsstl -->
				<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/three.js"></script>
				<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/stats.js"></script>
				<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/detector.js"></script>
				<script>

					var camera, scene, renderer,
						geometry, material, mesh, light1, stats;

					function trim (str) {
						str = str.replace(/^\s+/, '');
						for (var i = str.length - 1; i >= 0; i--) {
							if (/\S/.test(str.charAt(i))) {
								str = str.substring(0, i + 1);
								break;
							}
						}
						return str;
					}

					// Notes:
					// - STL file format: http://en.wikipedia.org/wiki/STL_(file_format)
					// - 80 byte unused header
					// - All binary STLs are assumed to be little endian, as per wiki doc
					var parseStlBinary = function(stl) {
						var geo = new THREE.Geometry();
						var dv = new DataView(stl, 80); // 80 == unused header
						var isLittleEndian = true;
						var triangles = dv.getUint32(0, isLittleEndian); 

						// console.log('arraybuffer length:  ' + stl.byteLength);
						// console.log('number of triangles: ' + triangles);

						var offset = 4;
						for (var i = 0; i < triangles; i++) {
							// Get the normal for this triangle
							var normal = new THREE.Vector3(
								dv.getFloat32(offset, isLittleEndian),
								dv.getFloat32(offset+4, isLittleEndian),
								dv.getFloat32(offset+8, isLittleEndian)
							);
							offset += 12;

							// Get all 3 vertices for this triangle
							for (var j = 0; j < 3; j++) {
								geo.vertices.push(
									new THREE.Vector3(
										dv.getFloat32(offset, isLittleEndian),
										dv.getFloat32(offset+4, isLittleEndian),
										dv.getFloat32(offset+8, isLittleEndian)
									)
								);
								offset += 12
							}

							// there's also a Uint16 "attribute byte count" that we
							// don't need, it should always be zero.
							offset += 2;   

							// Create a new face for from the vertices and the normal             
							geo.faces.push(new THREE.Face3(i*3, i*3+1, i*3+2, normal));
						}

						// The binary STL I'm testing with seems to have all
						// zeroes for the normals, unlike its ASCII counterpart.
						// We can use three.js to compute the normals for us, though,
						// once we've assembled our geometry. This is a relatively 
						// expensive operation, but only needs to be done once.
						geo.computeFaceNormals();

						mesh = new THREE.Mesh( 
							geo,
							// new THREE.MeshNormalMaterial({
							//     overdraw:true
							// }
							new THREE.MeshLambertMaterial({
								overdraw:true,
								color: 0xaa0000,
								shading: THREE.FlatShading
							}
														 ));
						scene.add(mesh);

						stl = null;
					};  

					var parseStl = function(stl) {
						var state = '';
						var lines = stl.split('\n');
						var geo = new THREE.Geometry();
						var name, parts, line, normal, done, vertices = [];
						var vCount = 0;
						stl = null;

						for (var len = lines.length, i = 0; i < len; i++) {
							if (done) {
								break;
							}
							line = trim(lines[i]);
							parts = line.split(' ');
							switch (state) {
								case '':
									if (parts[0] !== 'solid') {
										console.error(line);
										console.error('Invalid state "' + parts[0] + '", should be "solid"');
										return;
									} else {
										name = parts[1];
										state = 'solid';
									}
									break;
								case 'solid':
									if (parts[0] !== 'facet' || parts[1] !== 'normal') {
										console.error(line);
										console.error('Invalid state "' + parts[0] + '", should be "facet normal"');
										return;
									} else {
										normal = [
											parseFloat(parts[2]), 
											parseFloat(parts[3]), 
											parseFloat(parts[4])
										];
										state = 'facet normal';
									}
									break;
								case 'facet normal':
									if (parts[0] !== 'outer' || parts[1] !== 'loop') {
										console.error(line);
										console.error('Invalid state "' + parts[0] + '", should be "outer loop"');
										return;
									} else {
										state = 'vertex';
									}
									break;
								case 'vertex': 
									if (parts[0] === 'vertex') {
										geo.vertices.push(new THREE.Vector3(
											parseFloat(parts[1]),
											parseFloat(parts[2]),
											parseFloat(parts[3])
										));
									} else if (parts[0] === 'endloop') {
										geo.faces.push( new THREE.Face3( vCount*3, vCount*3+1, vCount*3+2, new THREE.Vector3(normal[0], normal[1], normal[2]) ) );
										vCount++;
										state = 'endloop';
									} else {
										console.error(line);
										console.error('Invalid state "' + parts[0] + '", should be "vertex" or "endloop"');
										return;
									}
									break;
								case 'endloop':
									if (parts[0] !== 'endfacet') {
										console.error(line);
										console.error('Invalid state "' + parts[0] + '", should be "endfacet"');
										return;
									} else {
										state = 'endfacet';
									}
									break;
								case 'endfacet':
									if (parts[0] === 'endsolid') {
										//mesh = new THREE.Mesh( geo, new THREE.MeshNormalMaterial({overdraw:true}));
										mesh = new THREE.Mesh( 
											geo, 
											new THREE.MeshLambertMaterial({
												overdraw:true,
												color: 0xaa0000,
												shading: THREE.FlatShading
											}
																		 ));
										scene.add(mesh);
										done = true;
									} else if (parts[0] === 'facet' && parts[1] === 'normal') {
										normal = [
											parseFloat(parts[2]), 
											parseFloat(parts[3]), 
											parseFloat(parts[4])
										];
										if (vCount % 1000 === 0) {
											console.log(normal);
										}
										state = 'facet normal';
									} else {
										console.error(line);
										console.error('Invalid state "' + parts[0] + '", should be "endsolid" or "facet normal"');
										return;
									}
									break;
								default:
									console.error('Invalid state "' + state + '"');
									break;
							}
						}
					};



					init();
					animate();

					function init() {

						//Detector.addGetWebGLMessage();

						scene = new THREE.Scene();

						camera = new THREE.PerspectiveCamera( 55, window.innerWidth / window.innerHeight, 1, 1000 );
						camera.position.z = 70;
						camera.position.y = 0;
						scene.add( camera );

						var directionalLight = new THREE.DirectionalLight( 0xffffff );
						directionalLight.position.x = 0; 
						directionalLight.position.y = 0; 
						directionalLight.position.z = 1; 
						directionalLight.position.normalize();
						scene.add( directionalLight );

						var xhr = new XMLHttpRequest();
						xhr.onreadystatechange = function () {
							if ( xhr.readyState == 4 ) {
								if ( xhr.status == 200 || xhr.status == 0 ) {
									var rep = xhr.response; // || xhr.mozResponseArrayBuffer;
									console.log(rep);
									parseStlBinary(rep);
									//parseStl(xhr.responseText);
									mesh.rotation.x = 5;
									mesh.rotation.z = .25;
									console.log('done parsing');
								}
							}
						}
						xhr.onerror = function(e) {
							console.log(e);
						}

						xhr.open( "GET", document.getElementById('stl-uri').value, true );
						xhr.responseType = "arraybuffer";
						//xhr.setRequestHeader("Accept","text/plain");
						//xhr.setRequestHeader("Content-Type","text/plain");
						//xhr.setRequestHeader('charset', 'x-user-defined');
						xhr.send( null );

						container = document.getElementById( '3d-contenedor' );

						renderer = new THREE.WebGLRenderer(); //new THREE.CanvasRenderer();
						renderer.setSize( window.innerWidth / 2 , window.innerHeight / 2 );

						container.appendChild( renderer.domElement );

					}

					function animate() {

						// note: three.js includes requestAnimationFrame shim
						requestAnimationFrame( animate );
						render();

					}

					function render() {

						//mesh.rotation.x += 0.01;
						if (mesh) {
							mesh.rotation.z += 0.01;
						}
						//light1.position.z -= 1;

						renderer.render( scene, camera );

					}

				</script>
				<!-- STL viewer -->

				<?php
				}
				?>
			</div>
		</div>	
		<?php endif; ?>

	<div id="primary" <?php generate_content_class();?>>
		<main id="main" <?php generate_main_class(); ?>>
			
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'recurso' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || '0' != get_comments_number() ) : ?>

					<div class="comments-area">
						<?php comments_template(); ?>
					</div>

				<?php endif;

			endwhile;

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	 do_action( 'generate_after_primary_content_area' );

	 generate_construct_sidebars();

get_footer();
