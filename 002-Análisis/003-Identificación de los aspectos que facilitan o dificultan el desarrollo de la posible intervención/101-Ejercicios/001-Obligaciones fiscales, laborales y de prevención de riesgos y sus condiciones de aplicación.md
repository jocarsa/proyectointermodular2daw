Obligaciones fiscales, laborales y de prevención de riesgos y sus condiciones de aplicación

Registro público de algoritmos en la CV (Comunitat Valenciana), para transparencia de algoritmos en servicios públicos.

Generales:

alta como autónomo
alta como empresa

IVA más declaración 303 trimestral

IRPF autonomo o impuesto de sociedades

retenciones y modelos periódicos

obligaciones fiscales como libros de ingresos

Obligaciones fiscales específicas de un SaaS de IA

Tratamiento de ingresos digitales

Aunque vendas un “chatbot IA”, fiscalmente se considera prestación de servicios digitales.

Si facturas a particulares de la UE → se aplica el IVA del país de destino (régimen OSS, ventanilla única).

Si facturas a empresas de la UE con VAT válido → operación intracomunitaria (IVA 0%, pero hay que declararlo en modelo 349).

GDPR y costes asociados (no es un impuesto, pero afecta):

Tendrás que documentar el cumplimiento de protección de datos.

Si gestionas datos sensibles (clientes de tus clientes), podrías necesitar un Delegado de Protección de Datos (DPD).

Esto conlleva gastos de consultoría legal recurrentes, que son fiscalmente deducibles.

Subvenciones y deducciones

Muchas líneas de ayuda (IVACE, fondos europeos, ENISA) obligan a justificar gastos de I+D.

Existe la deducción fiscal por I+D+i en el Impuesto de Sociedades (puede llegar al 42%).

Importante llevar bien la contabilidad para aprovecharlo.

Licencias de software y royalties

Si usas APIs de terceros (ej. OpenAI, WhatsApp Cloud API), son gastos deducibles.

Pero si revendes servicios de un tercero, ojo: debes repercutir IVA en tu factura aunque el proveedor sea extranjero (mecanismo de inversión del sujeto pasivo).

Obligaciones con la Seguridad Social

Aunque sea SaaS, si contratas personal técnico o comercial → alta en Régimen General.

Posibilidad de bonificaciones si contratas perfiles jóvenes o I+D.

Muy buen punto: una cosa es hablar de obligaciones fiscales; otra muy distinta (y emergente) es lo que la normativa de **transparencia algorítmica / gobernanza de IA** puede exigirte como proveedor o usuario de sistemas de IA. Aquí va un panorama con lo que hasta hoy existe, lo que está en tramitación, y las obligaciones (reales o previsibles) que podrías tener que cumplir:

---

## 📚 Lo que ya existe / se está desplegando

### Registro de algoritmos en la Comunitat Valenciana (“GVA ConfIA”)

* La Generalitat Valenciana ha lanzado un registro público de algoritmos llamado **GVA ConfIA** para que los ciudadanos conozcan cuándo se usa un algoritmo, con qué finalidad, qué datos lo alimentan y qué garantías existen frente a sesgos o decisiones injustas. ([DGTIC][1])
* En la actualidad está en fase piloto, e inicialmente contempla algoritmos de ámbitos como salud, educación y medioambiental. ([ESMARTCITY][2])
* Este registro es una obligación de **publicidad activa de la administración autonómica valenciana**, para los algoritmos que esta utilice, bajo los principios de transparencia. ([Universitat de València][3])

Importante: este registro **no implica automáticamente** que todas las empresas privadas deban inscribir sus algoritmos allí. Se dirige principalmente a las entidades públicas que usan sistemas automatizados para toma de decisiones administrativas. ([Open Government Partnership][4])

---

## ⚖️ Normativa europea y española sobre IA y transparencia algorítmica

Para saber qué obligaciones tienes hoy o próximamente, conviene mirar el nuevo marco regulador europeo y cómo se traslada a España:

1. **Reglamento de Inteligencia Artificial (IA Act / Ley de IA de la UE)**

   * El Reglamento de IA de la UE (aprobado en 2024) establece exigencias de transparencia, explicabilidad, trazabilidad y comunicación de información a los usuarios en determinados sistemas de IA. ([Parlamento Europeo][5])
   * Los sistemas considerados de **alto riesgo** estarán sujetos a obligaciones más estrictas (auditorías, documentación técnica, vigilancia, evaluación de riesgos). ([Parlamento Europeo][5])
   * Para sistemas más “ligeros”, habrá obligaciones de transparencia mínimas (por ejemplo, informar al usuario que está interactuando con IA, límites del sistema, recomendaciones de uso). ([Agencia Española de Protección de Datos][6])

2. **Transparencia-RGPD / obligaciones de información cuando hay tratamiento de datos personales**

   * Bajo el RGPD y su desarrollo en España (LOPDGDD), ya tienes obligaciones de transparencia hacia los usuarios cuyos datos procesas: informar qué datos, con qué finalidad, quién es responsable, derechos, etc. ([Agencia Española de Protección de Datos][6])
   * Cuando la IA intervenga en decisiones automatizadas que afecten a las personas, hay obligaciones adicionales de información y posibilidad de interponer recursos humanos si la decisión les perjudica. ([Agencia Española de Protección de Datos][6])

3. **Ley de Igualdad de Trato / no discriminación**

   * La Ley 15/2022 para la igualdad de trato incorpora obligaciones a evitar que las decisiones automatizadas basadas en algoritmos discriminen por razón de cualquier condición personal (sexo, origen, edad, discapacidad, etc.). ([Wikipedia][7])
   * Si tu sistema “decide” algo (o da recomendaciones) que puede tratar diferentemente a grupos protegidos, debes asegurarte de pruebas contra sesgos, auditorías, transparencia en criterios.

4. **Obligaciones futuras / sanciones y cumplimiento exigente**

   * Las autoridades nacionales (como la Agencia Española de Supervisión de la Inteligencia Artificial — AESIA) serán responsables de supervisar el cumplimiento de la normativa de IA en España. ([Wikipedia][8])
   * Si incumples obligaciones de transparencia, no explicas decisiones automatizadas, no haces auditorías o generas discriminaciones, podrías estar sujeto a sanciones administrativas (el proyecto de IA Act prevé multas para incumplimientos). ([Computing][9])
   * A partir de 2026 algunas obligaciones de etiquetado de contenido generado por IA entrarán en vigor (que los contenidos generados con IA deben indicar que lo son) según el Reglamento de IA. ([Cinco Días][10])

---

## 🧾 Qué obligaciones específicas podrías tener para tu proyecto (chatbot / SaaS IA)

Partiendo del proyecto que quieres construir (chatbot IA / SaaS con procesamiento automático), aquí las obligaciones concretas que deberías contemplar:

| Obligación                                        | Qué implica para tu proyecto                                                                                                                                                      |
| ------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Transparencia al usuario**                      | Informar claramente que el usuario está conversando con un sistema de IA, no con un humano, y cuáles son las limitaciones del sistema.                                            |
| **Documentación técnica / trazabilidad**          | Mantener documentación interna que describa cómo se entrena el modelo, con qué datos, qué versiones del modelo usas, métricas de sesgo, logs que permitan reconstruir decisiones. |
| **Explicabilidad**                                | Si el chatbot toma decisiones (ej. recomendar un producto, rechazar una petición), debes poder explicar de forma comprensible por qué lo hizo.                                    |
| **Evaluación de riesgos / auditorías**            | Análisis de riesgos en fases de diseño: qué puede salir mal (sesgo, discriminación, errores), mitigaciones, controles. Auditoría periódica del sistema.                           |
| **Protección de datos / conformidad RGPD**        | Si el chatbot maneja datos personales (nombres, emails, historial), cumplir con consentimiento, derechos de acceso, rectificación, supresión, portabilidad.                       |
| **No discriminación**                             | Asegurarte de que el algoritmo no discrimine grupos protegidos (sexo, edad, origen). Realizar pruebas de equidad.                                                                 |
| **Etiquetado de contenido IA (a partir de 2026)** | Si el sistema genera texto, audio, imagen o vídeo, deberás marcarlo como generado por IA cuando la intervención sea sustancial.                                                   |
| **Supervisión humana**                            | Tener mecanismos de supervisión humana, posibilidad de “recurrir” la respuesta del chatbot a un operador humano si el usuario lo solicita o si la decisión es crítica.            |
| **Conservación de logs / registros**              | Conserva registro de interacciones, decisiones del sistema, versiones del modelo, para auditoría futura o responsabilidad.                                                        |
| **Actualización / mantenimiento**                 | Si los datos cambian, debes revisar y reentrenar modelos, corregir sesgos emergentes, y documentar esos cambios.                                                                  |
| **Cooperar con supervisores**                     | Ante requerimientos de autoridades (por ejemplo AESIA, agencias de protección de datos), tener capacidad de exhibir la documentación y acreditar cumplimiento.                    |

---

## ⚠️ Lo que *no* parece que te exijan hoy pero podría exigirse

* Que inscribas tu algoritmo en **GVA ConfIA** (registro público autonómico) — salvo que actúes como administración pública valenciana.
* Que publiques en abierto el código completo o modelos sensibles, salvo que la normativa lo requiera como parte de obligaciones de alto riesgo.
* Que anticipadamente cumplas todas las obligaciones del AI Act si tu sistema no está en la categoría de “alto riesgo”.

---

Si quieres, puedo revisar **precisamente para tu chatbot (versión MVP)** qué nivel de riesgo tendría bajo el Reglamento IA y qué obligaciones concretas legales (transparencia, auditoría, registros) te corresponderían, para que lo ajustes de inicio. ¿Hacemos eso?

[1]: https://dgtic.gva.es/es/-/la-generalitat-presenta-el-nuevo-registro-de-algoritmos-gva-confia-para-una-ia-transparente-y-responsable?redirect=%2Fes%2Factualidad%3Fp_p_id%3Dcom_liferay_asset_publisher_web_portlet_AssetPublisherPortlet_INSTANCE_0YobAjUX6lT2%26p_p_lifecycle%3D0%26p_p_state%3Dnormal%26p_p_mode%3Dview%26_com_liferay_asset_publisher_web_portlet_AssetPublisherPortlet_INSTANCE_0YobAjUX6lT2_delta%3D5%26p_r_p_resetCur%3Dfalse%26_com_liferay_asset_publisher_web_portlet_AssetPublisherPortlet_INSTANCE_0YobAjUX6lT2_cur%3D1&utm_source=chatgpt.com "La Generalitat presenta el nuevo Registro de Algoritmos 'GVA ConfIA' para una IA transparente y responsable - Tecnologías de la Información y las Comunicaciones"
[2]: https://www.esmartcity.es/2025/05/26/generalitat-valenciana-lanza-registro-algoritmos-uso-responsable-administracion?utm_source=chatgpt.com "La Generalitat Valenciana lanza un registro de algoritmos para su uso responsable en la administración"
[3]: https://www.uv.es/cotino/publicaciones/informe_gvav3logos.pdf?utm_source=chatgpt.com "La implantación de la transparencia algorítmica"
[4]: https://www.opengovpartnership.org/es/the-open-gov-challenge/valencian-community-spain-create-a-public-algorithmic-registry/?utm_source=chatgpt.com "Comunidad Valenciana, España Crear un registro algorítmico público"
[5]: https://www.europarl.europa.eu/topics/es/article/20230601STO93804/ley-de-ia-de-la-ue-primera-normativa-sobre-inteligencia-artificial?utm_source=chatgpt.com "Ley de IA de la UE: primera normativa sobre inteligencia ..."
[6]: https://www.aepd.es/prensa-y-comunicacion/blog/inteligencia-artificial-transparencia?utm_source=chatgpt.com "Inteligencia artificial: Transparencia | AEPD"
[7]: https://es.wikipedia.org/wiki/Ley_para_la_igualdad_de_trato_%28Espa%C3%B1a%29?utm_source=chatgpt.com "Ley para la igualdad de trato (España)"
[8]: https://es.wikipedia.org/wiki/Agencia_Espa%C3%B1ola_de_Supervisi%C3%B3n_de_la_Inteligencia_Artificial?utm_source=chatgpt.com "Agencia Española de Supervisión de la Inteligencia Artificial"
[9]: https://www.computing.es/administracion/la-ue-ha-activado-la-supervision-y-las-sanciones-sobre-la-inteligencia-artificial/?utm_source=chatgpt.com "España pone en marcha control y multas a la inteligencia ..."
[10]: https://cincodias.elpais.com/legal/2025-09-17/las-empresas-deberan-etiquetar-los-contenidos-generados-por-ia-a-partir-de-agosto-de-2026.html?utm_source=chatgpt.com "Las empresas deberán etiquetar los contenidos generados por IA a partir de agosto de 2026"

