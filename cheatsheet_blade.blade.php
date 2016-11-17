{{ HTML::linkRoute('route_name', 'ALL USERS') }}	

<!-- Check if an old value is available. Usually used when validating with $validator from the controller, and then redirecting
	 to the same page and passing the old values and error messages to the view. -->
 <input class="form-control" type="text"{{( Input::old('email')) ? ' value="'.Input::old('email').'"'  :''}} name="email" >

