<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
      <a class="navbar-brand p-2" href="#">INFOpoint <i class="mdi mdi-car"></i></a>
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
