<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<section id="обратная-связь" className="py-24">
      <div className="container mx-auto">
        <div className="grid lg:grid-cols-2 gap-12 items-start">
          <div>
            <h2 className="text-4xl md:text-5xl font-black tracking-tight mb-6 text-foreground">
              СВЯЖИТЕСЬ <span className="text-gradient-primary">С НАМИ</span>
            </h2>
            <p className="text-muted-foreground text-lg mb-8 max-w-md leading-relaxed">
              Оставьте заявку, и наш специалист свяжется с вами для консультации и подбора оборудования.
            </p>
            <div className="space-y-4 text-muted-foreground">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">📞</div>
                <span>+7 (800) 123-45-67</span>
              </div>
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">✉️</div>
                <span>info@medicator.ru</span>
              </div>
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">📍</div>
                <span>г. Москва, ул. Примерная, 1</span>
              </div>
            </div>
          </div>

          <form onSubmit={handleSubmit} className="bg-card rounded-2xl p-8 border border-border space-y-5 shadow-sm">
            <div>
              <label className="text-sm text-muted-foreground mb-1.5 block">Ваше имя</label>
              <input
                type="text"
                required
                value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })
                className="w-full bg-muted border border-border rounded-xl px-5 py-3.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Иван Иванов"
              />
            </div>
            <div>
              <label className="text-sm text-muted-foreground mb-1.5 block">Телефон</label>
              <input
                type="tel"
                required
                value={form.phone}
                onChange={(e) => setForm({ ...form, phone: e.target.value })
                className="w-full bg-muted border border-border rounded-xl px-5 py-3.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="+7 (___) ___-__-__"
              />
            </div>
            <div>
              <label className="text-sm text-muted-foreground mb-1.5 block">Сообщение</label>
              <textarea
                rows={4}
                value={form.message}
                onChange={(e) => setForm({ ...form, message: e.target.value })
                className="w-full bg-muted border border-border rounded-xl px-5 py-3.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary resize-none"
                placeholder="Опишите ваш запрос..."
              />
            </div>
            <button
              type="submit"
              className="group w-full flex items-center justify-center gap-3 bg-primary text-primary-foreground px-8 py-4 rounded-xl text-base font-bold hover:opacity-90 transition-all"
            >
              ОТПРАВИТЬ ЗАЯВКУ
              <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
            </button>
          </form>
        </div>
      </div>
    </section>
    </body>
</html>