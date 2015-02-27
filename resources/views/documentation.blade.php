<html>
	<head>
		<title>Rabble+Rouser Laravel REST API</title>
		<style>
			html, body { padding: 0px; margin: 0px; }
			.container { padding: 10px; }
			.title { border: 1px solid #aaa; padding: 10px; text-align: center; background-color: #ddd;}
			.collection { margin-top: 10px; border: 1px solid #aaa; padding: 10px; background-color: #eee;}
			.collection .header { font-weight: bold; }
			.methods { border: 1px solid #aaa; background-color: #eee; margin-top: 10px;}
			.method { display: table-row-group;}
			.method .cell { display: table-cell; padding: 10px;}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Rabble + Rouser Laravel REST API</div>
				<div class="collection">
					<div>
						<span class="header">Collection:</span>
						<span class="resource">location</span>
					</div>
					<div>
						<span class="header">URI:</span>
						<span class="uri">http://localhost:8000/api/v1/location</span>
					</div>
					<div class="methods">
						<div class="method">
							<span class="header cell">Method</span>
							<span class="header cell">URI</span>
							<span class="header cell">Description</span>
						</div>
						<div class="method">
							<span class="cell">GET</span>
							<span class="cell">http://localhost:8000/api/v1/location</span>
							<span class="cell">List all Locations</span>
						</div>
						<div class="method">
							<span class="cell">GET</span>
							<span class="cell">http://localhost:8000/api/v1/location/<i>resourceid</i>/location</span>
							<span class="cell">List all decendants for a specific Location identified by its <i>resourceid</i></span>
						</div>
						<div class="method">
							<span class="cell">GET</span>
							<span class="cell">http://localhost:8000/api/v1/location/<i>resourceid</i></span>
							<span class="cell">Retrieve a specific Location identified by its <i>resourceid</i>.</span>
						</div>
						<div class="method">
							<span class="cell">GET</span>
							<span class="cell">http://localhost:8000/api/v1/location/<i>resourceid1</i>/<i>resourceid2</i></span>
							<span class="cell">Retrieve the closest shared ancestor between the two Locations identified by <i>resourceid1</i> and <i>resourceid2</i>. If no shared ancestor Location exists, then an empty json array will be returned.</span>
						</div>
						<div class="method">
							<span class="cell">POST</span>
							<span class="cell">http://localhost:8000/api/v1/location</span>
							<span class="cell">Create a new root level Location.</br>Expected POST Parameter: address</br>Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043</span>
						</div>
						<div class="method">
							<span class="cell">POST</span>
							<span class="cell">http://localhost:8000/api/v1/location/<i>resourceid</i>/location</span>
							<span class="cell">Create a new child Location for a parent Location identified by its <i>resourceid</i>.</br>Expected POST Parameter: address</br>Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043</span>
						</div>
						<div class="method">
							<span class="cell">PUT</span>
							<span class="cell">http://localhost:8000/api/v1/location/<i>resourceid</i></span>
							<span class="cell">Update a specific Location idetified by its <i>resourceid</i>.</br>Expected PUT Parameter: address</br>Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043</span>
						</div>
						<div class="method">
							<span class="cell">DELETE</span>
							<span class="cell">http://localhost:8000/api/v1/location/<i>resourceid</i></span>
							<span class="cell">Delete a specific Location identified by its <i>resourceid</i></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
