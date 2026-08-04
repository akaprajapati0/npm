<section class="news_update wow fadeInUp">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <!-- Left Side: Title -->
      <div class="col-lg-6">
        <div class="section-title d-flex flex-column">
          <h2>News, Articles and Resources</h2>
          <p>Read our blogs covering health, access, and updates</p>
        </div>
      </div>

      <!-- Right Side: Button -->
      <!-- mt-3 mt-lg-0 -->
      <div class="col-lg-3 text-lg-end text-start ">
        <a href="<?= base_url(); ?>news-and-updates" class="button-new-regular">
          <div class="button-content-sec d-flex align-items-center justify-content-lg-end">
            <p class="mb-0 me-2">View All News</p>
            <i class="button__arrow">
              <svg viewBox="0 0 24 24">
                <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
              </svg>
            </i>
          </div>
        </a>
      </div>
    </div>

    <!-- Your news cards below stay unchanged -->





    <div class="row">
      <?php foreach ($latest_news as $index => $news): ?>
        <?php if ($index == 0): ?>
          <!-- First news (big left box) -->
          <div class="col-lg-5">

            <?php
            $category_slug = strtolower(str_replace(' ', '-', $news['category_name']));
            ?>
            <a href="<?= base_url($category_slug . '/' . $news['slug']); ?>">

              <div class="announcement_box">
                <div class="announcement_box2">

                  <!-- <div class="announcement_box_date"><?= date("d.m.Y", strtotime($news['createdAt'])); ?></div>
                    <h3><?= $news['name']; ?></h3>
                  </div> -->
                  <div class="announcement_box_category"><?= $news['category_name']; ?></div>
                  <div class="announcement_box_date"><?= date("d.m.Y", strtotime($news['createdAt'])); ?></div>
                  <h3><?= $news['name']; ?></h3>
                </div>


                <div class="announcement_box_img_outer">
                  <img src="<?= base_url('assets/images/news/' . $news['image']); ?>" alt="News">
                </div>
                <div class="glow"></div>
              </div>
            </a>
          </div>
          <div class="col-lg-7 hNewsCol7">
          <?php else: ?>
            <!-- Next two news (right side small boxes) -->

            <?php
            $category_slug = strtolower(str_replace(' ', '-', $news['category_name']));
            ?>
            <a href="<?= base_url($category_slug . '/' . $news['slug']); ?>">
              <div class="announcement_box_right">
                <div class="row">
                  <div class="col-lg-5 hNewsPro">
                    <div class="announcement_box_profile">
                      <img src="<?= base_url('assets/images/news/' . $news['image']); ?>" alt="News">
                    </div>
                  </div>
                  <div class="col-lg-7">
                    <div class="announcement_box_right_box2">

                      <!-- <div class="announcement_box_right_box_date"><?= date("d.m.Y", strtotime($news['createdAt'])); ?></div>
                        <h3><?= $news['name']; ?></h3>
                      </div> -->
                      <div class="announcement_box_category"><?= $news['category_name']; ?></div>
                      <div class="announcement_box_right_box_date"><?= date("d.m.Y", strtotime($news['createdAt'])); ?></div>
                      <h3><?= $news['name']; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
          </div>
    </div>
  </div>
  </div>
</section>