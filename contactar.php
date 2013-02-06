  <div class="wrapper">

	       <div class="grids top">

		    <div class="grid-6 grid">
			 <h2>Address</h2>
			 <div>
			      <p class="bottom">
				   Jane Doe<br />
				   Some street 123<br />
				   Name of State<br />
				   Country<br /><br />
				   Phone: 123 456 789<br />
				   Fax: 123 456 789 - 11<br />
				   Email: jane@some.com
                              </p>
			 </div>


			 <div class="green bottom">
			      <h3>Formalize</h3>
			      <p>This subpage includes the great JQuery plugin <strong>
					<a href="http://formalize.me/" title="Formalize Website">Formalize</a></strong>
				   by Nathan Smith.
				   <a href="http://formalize.me/" title="Formalize Website">Visit the website</a> to find out what it does and see the demos!
				   You don´t have to use a table as shown here (this is just an example), you can build your form without tables, too.
				   Inspect the CSS to utilize the classes that fit your needs.<br />
				   Comment or delete the section "Forms" in inuit.css when you make use of Formalize so the styles won´t interfere.
			      </p>
			 </div>

			 <div>
			      <p class="message warning bottom">
				   <b>Note:</b> This is just a demo for contact form styles and behaviour. <b>It doesn't actually submit anything.</b>
				   To make it work, you will have to include a fitting script.
                              </p>
			 </div>
		    </div>




		    <!--===============================================================  Contact form =====================================================================================-->
		    <div class="grid-10 grid">

			 <h2>Contact us</h2>
			 <form  action="#" method="post" enctype="multipart/form-data" onsubmit="return false">
                              <table class="form">
				   <tr>
					<th>
					     <label for="name">
						  Name
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="name" name="name" required="required" />

					</td>
				   </tr>
				   <tr>
					<th>
					     <label for="email">
						  Email
					     </label>
					</th>
					<td>

					     <input class="input_full" type="email" id="email" name="email" required="required" />
					</td>
				   </tr>

				   <tr>

					<th>
					     <label for="tel">
						  Phone
					     </label>
					</th>
					<td>
					     <input class="input_full" type="tel" id="tel" name="tel" required="required" />
					</td>
				   </tr>

				   <tr>
					<th>
					     <label for="url">
						  URL
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="url" name="url" placeholder="http://" />
					</td>

				   </tr>
				   <tr>
					<th>
					     <label for="subject">
						  Subject
					     </label>
					</th>
					<td>
					     <select class="input_full" id="subject" name="subject">

						  <option value="">Choose subject...</option>

						  <option value="1k_2k">Question</option>
						  <option value="2k_3k">Project</option>
						  <option value="3k_4k">Feedback</option>
						  <option value="4k_5k">Other</option>

					     </select>
					</td>
				   </tr>
				   <tr>

					<th>
					     <label for="priority_normal">
						  Priority
					     </label>
					</th>
					<td>
					     <input type="radio" name="priority" id="priority_urgent" value="Urgent">
					     <label for="priority_urgent">
						  Urgent
					     </label>

					     &nbsp;
					     &nbsp;
					     <input type="radio" name="priority" id="priority_normal" value="Normal" checked="checked">
					     <label for="priority_normal">
						  Normal
					     </label>
					     &nbsp;
					     &nbsp;
					     <input type="radio" name="priority" id="priority_low" value="Low">

					     <label for="priority_low">
						  Low
					     </label>
					</td>
				   </tr>
				   <tr>
					<th>

					     <label for="description">
						  Your<br />
						  message
					     </label>
					</th>
					<td>
					     <textarea id="description" name="description" rows="8" required="required" placeholder="Please write your message here."></textarea>
					</td>

				   </tr>
				   <tr>
					<th>
					     <label for="cc">
						  <abbr title="Courtesy Copy">CC</abbr>
					     </label>

					</th>
					<td>
					     <input type="checkbox" id="cc" name="cc" value="1" />
					     <label for="cc">
						  Send me a copy of this email
					     </label>
					</td>
				   </tr>
                              </table>

                              <p>
				   <input type="submit" value="Send" class="float_left" />
				   <input type="reset" value="Reset" class="float_right">
                              </p>
			 </form>


		    </div><!--end of grid-10-->
	       </div><!--end of grids-->