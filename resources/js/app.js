import './bootstrap';

console.log('like js loaded');

document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".js-like-btn");
  if (!btn) return;

  // 🔴 ここが決定打
  e.preventDefault();
  e.stopPropagation();
  e.stopImmediatePropagation();

  // 親の <a> を無効化
  const anchor = btn.closest("a");
  if (anchor) {
    anchor.removeAttribute("href");
  }

  // --- Like 処理 ---
  const form = btn.closest(".js-like-form");
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  const likedNow = form.dataset.liked === "1";
  const url = likedNow ? form.dataset.destroyUrl : form.dataset.storeUrl;

  const fd = new FormData();
  fd.append("_token", csrf);
  if (likedNow) fd.append("_method", "DELETE");

  const res = await fetch(url, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Accept": "application/json",
    },
    body: fd,
  });

  const data = await res.json();
  form.dataset.liked = data.liked ? "1" : "0";

  form.querySelector("i").className =
    data.liked ? "fa-solid fa-heart text-danger" : "fa-regular fa-heart";

  document.querySelector(`.js-like-count[data-post-id="${form.dataset.postId}"]`)
    .textContent = data.count;
}, true);



