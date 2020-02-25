

              <div class="card-body">
                <div class="table-responsive">

                  <table class="table">
                    <thead>
                      <th colspan="2"></th>
                      <th colspan="2">Title</th>
                      <th colspan="">Created at</th>
                      <th colspan="3">Team</th>
                      <th colspan="3">Roles</th>
                      <th colspan="3">Targeted Audience</th>
                      <th colspan="3">Likes</th>
                      <th colspan="3">Dislike</th>
                      <th colspan="3">blank_field</th>
                      <th colspan="3">blank_field</th>

                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td class=""style="width: 7%;">
                          <a href="" style="padding-right: 3px;"><i class="fa fa-edit" style="color:gray"></i></a>
                          <a href="<?php echo e(url('dashboard/deletepost/'.$post->id)); ?>" style="padding-right: 3px;"> <i class="fa fa-trash" style="color:gray"></i> </a>
                          <a href="" style="padding-right: 3px;"><i class="fa fa-eye" style="color:gray"></i></a>
                        </td>
                             <?php
                        $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
                        if($post->cover_image){
                            $cover_image=$post->cover_image;
                        }else{
                          $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
                        }

                        ?>
                        <td colspan="2"> <img src="<?php echo e($cover_image); ?>" height="70px" width="60px" class="pull-left">
                          <span class="pl-10" style="display: flex;text-transform: uppercase;"><?php echo e($post->title); ?></span>
                        </td>
                        <td colspan="2"> <?php echo e($post->created_at); ?></td>
                        <td colspan="3"> <?php echo e($post->t_name); ?></td>
                        <td colspan="3"> <?php echo e($post->p_name); ?></td>
                        <td colspan="3"> 2812</td>
                        <td colspan="3"> <?php echo e($post->likes); ?></td>
                        <td colspan="3"> <?php echo e($post->dislikes); ?></td>
                        <td colspan="3"> -</td>
                        <td colspan="3"> -</td>

                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                  </table>
                </div>
              </div>
