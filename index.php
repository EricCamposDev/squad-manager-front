<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Squad Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js" integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
      $(function() {

        function maskPhone(){
          $(".phone").mask("(99) 99999-9999")
        }

        maskPhone()
        
      })
    </script>
  </head>
  <body>

    <?php
      require_once("components/notifications.php");
      $squads = json_decode(file_get_contents("http://localhost:3333/squad"), true);
    ?>

    <div class="container">

      <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
            <strong>SQUAD MANAGER</strong>
          </a>

          <span class="navbar-text">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".new-squad">Create New Squad</button>
          </span>
        </div>
      </nav>

      <div class="modal fade new-squad" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <form action="controllers/new-squad.php" method="post">

              <div class="modal-header">
                <h5 class="modal-title">new Squad</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">


                <div class="mb-3 row">
                  <label for="squadname" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="squad_name" class="form-control" id="squadname" required />
                  </div>
                </div>

                <hr>

                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="4">
                        <button class="btn btn-primary btn-new-member" type="button">New Member Form</button>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="tbody-new-member">
                    <tr>
                      <td>
                        <input type="text" name="name[]" class="form-control" placeholder="ex: John Doe" required />
                      </td>
                      <td>
                        <input type="email" name="email[]" class="form-control" placeholder="ex: john@doe.com" required />
                      </td>
                      <td>
                        <input type="text" name="phone[]" class="form-control phone" placeholder="ex: +1 234 3423" required />
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger delete-squad-line">X</button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <script type="text/javascript">
                  $(function() {

                    function removeRowLineSquad(){
                      $(".delete-squad-line").click(function() {
                        $(this).parent().parent().remove()
                      })
                    }

                    removeRowLineSquad()

                    var contentInputModel = $(".tbody-new-member").html()
                    $(".btn-new-member").click(function(){
                      $(".tbody-new-member").append(contentInputModel)
                      removeRowLineSquad()
                      maskPhone()
                    })

                    
                  })
                </script>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <?php
        if( !empty($squads) ):
      ?>
      <div class="row">
        <?php
          foreach($squads as $squad):
        ?>
        <div class="col-3">
          <div class="card" style="margin: 5px">
            <img src="https://img.freepik.com/vetores-gratis/iniciando-uma-ilustracao-de-conceito-de-projeto-de-negocios_114360-7632.jpg?t=st=1650052602~exp=1650053202~hmac=4abf741e67cfbbf381773671d21ffa594161fede6a344280f36fb314a8bd74da&w=996" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?=$squad['name']; ?></h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".manager-squad-<?=$squad['id']; ?>">Manager</a>
              <a href="#" data-bs-toggle="modal" data-bs-target=".delete-squad-<?=$squad['id']; ?>" class="btn btn-danger">Delete</a>
            </div>
          </div>

          <!-- gerenciar equipes - modal -->
          <div class="modal fade manager-squad-<?=$squad['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <form action="controllers/delete-squad.php" method="post">
                  <input type="hidden" name="id" value="<?=$squad['_id']; ?>">
                  <div class="modal-header">
                    <h5 class="modal-title"><strong><?=$squad['name']; ?></strong> - Manager Squad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <div class="row justify-content-md-center">
                      <div class="col-lg-3">
                        <img width="100%" class="img-thumbnail" src="https://img.freepik.com/vetores-gratis/iniciando-uma-ilustracao-de-conceito-de-projeto-de-negocios_114360-7632.jpg?t=st=1650052602~exp=1650053202~hmac=4abf741e67cfbbf381773671d21ffa594161fede6a344280f36fb314a8bd74da&w=996">
                        
                        <br>
                        <br>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".edit-squad-<?=$squad['id']; ?>">Edit Squad</button>



                      </div>
                      <div class="col-lg-9">

                        <div class="row">
                          <h4>Members</h4>
                          <?php
                            foreach($squad['members'] as $member):
                          ?>  
                          <div class="col-lg-4"> 
                            <div class="card mb-3">
                              <div class="row g-0">
                                
                                <div class="col-md-4">
                                  <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-vector-user-profile-default-avatar-profile-vector-user-profile-profile-179376714.jpg" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                  <div class="card-body">
                                    <h5 class="card-title"><?=$member['name']; ?></h5>
                                    <p class="card-text">E-mail: <?=$member['email']; ?></p>
                                    <p class="card-text">phone: <?=$member['phone']; ?></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                            endforeach;
                          ?>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Exit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- editar equipe - modal -->
          <div class="modal fade edit-squad-<?=$squad['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <form action="controllers/edit-squad.php" method="post">

                  <input type="hidden" name="id" value="<?=$squad['_id']; ?>">

                  <div class="modal-header">
                    <h5 class="modal-title">Edit Squad</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">


                    <div class="mb-3 row">
                      <label for="squadname" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" name="squad_name" class="form-control" id="squadname" value="<?=$squad['name']; ?>" required />
                      </div>
                    </div>

                    <hr>

                    <table class="table">
                      <thead>
                        <tr>
                          <th colspan="4">
                            <button class="btn btn-primary btn-new-member" type="button">New Member Form</button>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="tbody-new-member">
                        <?php
                          foreach($squad['members'] as $member):
                        ?>
                        <tr>
                          <td>
                            <input type="text" name="name[]" value="<?=$member['name']; ?>" class="form-control" placeholder="ex: John Doe" required />
                          </td>
                          <td>
                            <input type="email" name="email[]" value="<?=$member['email']; ?>" class="form-control" placeholder="ex: john@doe.com" required />
                          </td>
                          <td>
                            <input type="text" name="phone[]" value="<?=$member['phone']; ?>" class="phone form-control" placeholder="ex: +1 234 3423" required />
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger delete-squad-line">X</button>
                          </td>
                        </tr>
                        <?php
                          endforeach;
                        ?>
                      </tbody>
                    </table>

                    <script type="text/javascript">
                      $(function() {

                        function removeRowLineSquad(){
                          $(".delete-squad-line").click(function() {
                            $(this).parent().parent().remove()
                          })
                        }

                        removeRowLineSquad()

                        var contentInputModel = '\
                        <tr>\
                          <td>\
                            <input type="text" name="name[]" class="form-control" placeholder="ex: John Doe" required />\
                          </td>\
                          <td>\
                            <input type="email" name="email[]" class="form-control" placeholder="ex: john@doe.com" required />\
                          </td>\
                          <td>\
                            <input type="text" name="phone[]" class="form-control phone" placeholder="ex: +1 234 3423" required />\
                          </td>\
                          <td>\
                            <button type="button" class="btn btn-danger delete-squad-line">X</button>\
                          </td>\
                        </tr>';

                        $(".btn-new-member").click(function(){
                          $(".tbody-new-member").append(contentInputModel)
                          removeRowLineSquad()
                        })


                      })
                    </script>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- deletar equipe - modal --->
          <div class="modal fade delete-squad-<?=$squad['id']; ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="controllers/delete-squad.php" method="post">
                  <input type="hidden" name="id" value="<?=$squad['_id']; ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Delete Squad <strong><?=$squad['name']; ?></strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure that want delete this squad?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">yes, Delete</button>
                  </div>
                </form>
              </div>
            </div>
          </div>


        </div>
        <?php
          endforeach;
        ?>
      </div>
      <?php
        else:
      ?> 

        <div class="card bg-dark text-white" style="margin-top: 30px; margin-bottom: 40px;">
          <img src="https://img.freepik.com/fotos-gratis/equipe-de-negocios-planejando-uma-estrategia-de-marketing_53876-102032.jpg?t=st=1650298708~exp=1650299308~hmac=7d52246878ae98a537e725cd9b0fcc9fed8dd4d019068844bf593938260497da&w=1380" class="card-img" alt="...">
          <div class="card-img-overlay">
            <h1 class="card-title">YOU DON'T HAVE SQUADS...</h1>
            <p class="card-text">create your first squad</p>
          </div>
        </div>

      <?php
        endif;
      ?>
    </div>

    <footer class="fixed-bottom">
      <p class="text-center">Developer by: Eric Campos - using <strong>Boottsrap 5</strong></p>
    </footer>

    <script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
