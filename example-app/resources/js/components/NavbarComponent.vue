<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
      <a class="navbar-brand p-2" href="#">INFOpoint</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-collapse" aria-controls="nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav-collapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Cars</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/part">Parts</router-link>
          </li>
          
        </ul>
        <!--<form class="d-flex ">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
        <ul class="navbar-nav ml-auto">
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <em>User</em>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li><a class="dropdown-item" href="#">Sign Out</a></li>
            </ul>
          </li>
        </ul>-->
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'NavbarComponent',
};
</script>

<style scoped>
*{
  font-family:"Reddit Mono",monospace;
  color:white;
  font-weight:600;
  font-size:large;
}

</style>
