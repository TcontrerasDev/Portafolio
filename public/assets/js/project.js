const BASE_URL = document.querySelector('meta[name="base-url"]')?.content ?? '';
let projects = [];

function esc(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

function safeUrl(url) {
  return /^https?:\/\//i.test(String(url)) ? url : "#";
}

async function loadProjects(category = "todos") {
  const contenedor = document.getElementById("bento-projects");
  const url =
    category === "todos"
      ? BASE_URL + "/api/proyectos"
      : `${BASE_URL}/api/proyectos?categoria=${encodeURIComponent(category)}`;

  try {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error(`Error en la petición: ${response.status}`);
    }

    const data = await response.json();
    contenedor.innerHTML = "";

    if (data.length === 0) {
      contenedor.innerHTML =
        '<p class="text-white text-center">No hay proyectos para mostrar.</p>';
      return;
    }

    renderProjects(data);

    // Solo en la carga inicial (projects aún vacío) construimos las categorías
    if (projects.length === 0) {
      projects = data;
      renderCategories(data);
    }
  } catch (error) {
    console.error("Error al obtener proyectos:", error);
    contenedor.innerHTML = `<p class="text-danger text-center">Error al cargar proyectos: ${esc(error.message)}</p>`;
  }
}

function renderCategories(data) {
  const containCategories = document.getElementById("categories");

  // Extraemos categorías únicas usando Set
  const categoriasUnicas = [...new Set(data.map((p) => p.categoria))];

  const li = categoriasUnicas
    .map(
      (categoria) => `
    <li>
      <button class="btn-cat" data-category="${esc(categoria)}">
        ${esc(categoria)}
      </button>
    </li>
    `,
    )
    .join("");

  containCategories.innerHTML = `
    <li>
      <button class="btn-cat active" data-category="todos">Todos</button>
    </li>
    ${li}`;

  const btnCategory = document.querySelectorAll(".btn-cat");

  btnCategory.forEach((btn) => {
    btn.addEventListener("click", function () {
      const category = btn.dataset.category;
      btnCategory.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
      loadProjects(category);
    });
  });
}

function renderProjects(data) {
  const contenedor = document.getElementById("bento-projects");

  // Inyección del HTML dinámico
  const html = data
    .map(
      (project) => `
        <article class="proyect" style="opacity: 0;">
            <a href="${safeUrl(project.link)}" target="_blank" class="d-block w-100 h-100 text-decoration-none">
                <div class="box-img">
                    <img src="assets/img/${esc(project.codigo_imagen)}" alt="${esc(project.titulo)}">
                </div>
                <div class="box-info">
                    <h3 class="title">${esc(project.titulo)}</h3>
                    <i class="bi bi-box-arrow-up-right"></i>
                </div>
            </a>
        </article>
    `,
    )
    .join("");

  contenedor.innerHTML = html;

  // Calcula el targetY según el ancho actual
  const getTargetY = (index) => {
    const isDesktop = window.innerWidth > 765;
    const isEven = index % 2 !== 0;
    return isDesktop && isEven ? 64 : 0;
  };

  // Aplica las posiciones actuales sin animar (para resize inmediato)
  const updatePositions = () => {
    const proyects = contenedor.querySelectorAll(".proyect");
    proyects.forEach((proyect, index) => {
      proyect.style.transform = `translateY(${getTargetY(index)}px)`;
    });
  };

  const stopInView = inView(
    "#bento-projects",
    () => {
      const proyects = contenedor.querySelectorAll(".proyect");

      proyects.forEach((proyect, index) => {
        const targetY = getTargetY(index);

        animate(
          proyect,
          {
            opacity: [0, 1],
            y: [targetY + 50, targetY],
          },
          {
            duration: 0.8,
            delay: index * 0.15,
            easing: "ease-out",
          },
        );
      });

      // 2. LLAMAMOS A LA FUNCIÓN DE PARADA
      // Esto "mata" el observador para que la animación no se repita nunca más.
      stopInView();
    },
    { margin: "0px 0px -50px 0px" },
  );

  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(updatePositions, 150);
  });
}

// Inicialización al cargar el DOM
document.addEventListener("DOMContentLoaded", () => loadProjects());
