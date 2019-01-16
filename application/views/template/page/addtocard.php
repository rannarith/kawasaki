<div class="container">
  <div class="row">
    <h2 class="loginlabel">Login </h2>
    <div class="login">
      <div class="col-sm-12">
        <form method="POST" action="<?php echo base_url().'page/login/'?>">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail3" placeholder="Email" required="required" name="email">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword3" placeholder="Password" required="required" name="password">
            </div>
          </div>
          <div class="form-group">
              <ul>
                  <li><label class="inline"><input type="checkbox"><span class="input"></span>Remember Me</label></li>
                  <li><label class="inline"></span>Forgotten Password?</label></li>
                  <li><a href="<?php echo base_url().'page/register/'?>"><label class="inline"></span>Register</label></a></li>
              </ul>
          </div>
          <div class="form-group row">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary loginbtn">Log In</button>
            </div>
          </div>
        </form>
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
</div>
