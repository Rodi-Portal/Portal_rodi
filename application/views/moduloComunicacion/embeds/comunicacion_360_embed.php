<div class="com360-dev-wrap">
  <div class="com360-hero">
    <div class="com360-badge">
      En desarrollo
    </div>

    <div class="com360-icon-box">
      <i class="fas fa-broadcast-tower"></i>
    </div>

    <div class="com360-content">
      <h2 class="com360-title">Communication 360</h2>
      <p class="com360-subtitle">
        Este espacio está reservado para el nuevo módulo de comunicación 360.
        Próximamente aquí integraremos nuevas vistas, flujos y componentes especializados.
      </p>

      <div class="com360-grid">
        <div class="com360-card-item">
          <div class="com360-card-icon">
            <i class="fas fa-project-diagram"></i>
          </div>
          <div>
            <h4>Arquitectura modular</h4>
            <p>Base preparada para crecer por etapas sin afectar Comunicación Interna.</p>
          </div>
        </div>

        <div class="com360-card-item">
          <div class="com360-card-icon">
            <i class="fas fa-users"></i>
          </div>
          <div>
            <h4>Experiencia empresarial</h4>
            <p>Diseño orientado a un entorno SaaS profesional, claro y escalable.</p>
          </div>
        </div>

        <div class="com360-card-item">
          <div class="com360-card-icon">
            <i class="fas fa-layer-group"></i>
          </div>
          <div>
            <h4>Sección independiente</h4>
            <p>Este módulo tendrá su propio embebido y su propia evolución funcional.</p>
          </div>
        </div>
      </div>

      <div class="com360-note">
        <strong>Siguiente etapa:</strong> después de los ajustes en Comunicación Interna,
        continuaremos con la construcción de esta sección.
      </div>
    </div>
  </div>
</div>

<style>
.com360-dev-wrap{
  padding: 8px 4px 20px;
}

.com360-hero{
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  padding: 34px 34px 30px;
  background:
    radial-gradient(circle at top right, rgba(255,255,255,.55), rgba(255,255,255,0) 28%),
    linear-gradient(135deg, #f8fbff 0%, #eef4ff 45%, #f7f3ff 100%);
  border: 1px solid #e4eaf5;
  box-shadow:
    0 10px 30px rgba(15, 23, 42, 0.08),
    inset 0 1px 0 rgba(255,255,255,.65);
}

.com360-hero::before{
  content: "";
  position: absolute;
  top: -40px;
  right: -40px;
  width: 180px;
  height: 180px;
  background: radial-gradient(circle, rgba(217, 70, 239, .14) 0%, rgba(217, 70, 239, 0) 70%);
  pointer-events: none;
}

.com360-badge{
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 7px 14px;
  border-radius: 999px;
  background: rgba(124, 58, 237, 0.10);
  color: #6d28d9;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .3px;
  text-transform: uppercase;
  margin-bottom: 18px;
}

.com360-icon-box{
  width: 68px;
  height: 68px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
  color: #fff;
  font-size: 28px;
  box-shadow: 0 12px 24px rgba(124, 58, 237, .22);
  margin-bottom: 18px;
}

.com360-content{
  max-width: 980px;
}

.com360-title{
  margin: 0 0 10px;
  font-size: 32px;
  font-weight: 800;
  color: #18212f;
  letter-spacing: -.4px;
}

.com360-subtitle{
  margin: 0 0 26px;
  font-size: 15px;
  line-height: 1.7;
  color: #4b5563;
  max-width: 760px;
}

.com360-grid{
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 18px;
  margin-bottom: 24px;
}

.com360-card-item{
  display: flex;
  gap: 14px;
  align-items: flex-start;
  min-height: 130px;
  padding: 18px;
  border-radius: 18px;
  background: rgba(255,255,255,.78);
  border: 1px solid rgba(226, 232, 240, .95);
  box-shadow: 0 8px 22px rgba(15, 23, 42, .06);
}

.com360-card-icon{
  flex: 0 0 42px;
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(59,130,246,.12), rgba(168,85,247,.16));
  color: #7c3aed;
  font-size: 18px;
}

.com360-card-item h4{
  margin: 0 0 8px;
  font-size: 16px;
  font-weight: 700;
  color: #1f2937;
}

.com360-card-item p{
  margin: 0;
  font-size: 13px;
  line-height: 1.65;
  color: #6b7280;
}

.com360-note{
  border-left: 4px solid #8b5cf6;
  background: rgba(255,255,255,.72);
  border-radius: 14px;
  padding: 14px 16px;
  font-size: 14px;
  color: #374151;
  box-shadow: 0 6px 16px rgba(15, 23, 42, .05);
}

@media (max-width: 992px){
  .com360-grid{
    grid-template-columns: 1fr;
  }

  .com360-title{
    font-size: 28px;
  }
}

@media (max-width: 576px){
  .com360-hero{
    padding: 24px 18px 22px;
    border-radius: 20px;
  }

  .com360-title{
    font-size: 24px;
  }

  .com360-subtitle{
    font-size: 14px;
  }
}
</style>