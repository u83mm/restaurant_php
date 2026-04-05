<?php
declare(strict_types=1);

use Application\model\classes\PageClass;

$page = new PageClass();
$page->title = "My Restaurant | AI Dashboard";

$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
<section class="ai-dashboard">
    <h3>AI DASHBOARD</h3>
    <div id="retraining">
        <strong>¿Has añadido nuevas frases de entrenamiento?</strong><br>
        <button id="btnTrain">
            🚀 Re-entrenar Cerebro de la IA
        </button>
        <span id="trainStatus"></span>
    </div>
    <div>
        <h3>🧠 AI Knowledge Management</h3>
        <p>Add phrases to train or new responses.</p>
        
        <?php foreach ($intents as $intent) : ?>
            <div class="intent-card">
                <h3>Tag: <strong><?php echo $intent['tag']; ?></strong></h3>
                <div class="grid">
                    <div>
                        <strong>Training phrases:</strong>
                        <ul>
                            <?php foreach($patterns as $pattern): ?>
                                <?php if($intent['id'] == $pattern['intent_id']): ?>
                                    <li><?php echo $pattern['pattern_text'] ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div>
                        <strong>Posible responses:</strong>
                        <ul>
                            <?php foreach($responses as $response): ?>
                                <?php if($intent['id'] == $response['intent_id']): ?>
                                    <li><?php echo $response['response_text'] ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="intent_id" value="<?php echo $intent['id'] ?>">
                    <input type="text" name="new_pattern" id="new_pattern" placeholder="New training phrase...">
                    <input type="text" name="new_response" id="new_response" placeholder="New bot response..."></br>
                    <button type="submit">Update intent</button>
                </form>
            </div>
        <?php endforeach;?>
    </div>
    <div>
        <hr>
        <h2>🕵️ Registro de Consultas (Logs)</h2>
        <div class="query-registry-buttons">
            <form method="POST" action="/admin/dashboardAI/clearLogs" onsubmit="return confirm('¿Estás seguro de limpiar los logs?');">            
                <button type="submit" >
                    🧹 Limpiar historial antiguo (>7 días)
                </button>
            </form>
            <form method="POST" action="/admin/dashboardAI/clearAllLogs" onsubmit="return confirm('¿Estás seguro de borrar todos los logs?');">            
                <button type="submit" >
                    🗑️ Borrar todos los logs
                </button>
            </form>
        </div>
        <table id="query-registry">            
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario dijo...</th>
                    <th>IA respondió...</th>
                    <th>Tag detectado</th>
                    <th>Confianza</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($logs)): ?>
                    <?php foreach($logs as $log): ?>
                    <tr>
                        <td><?php echo $log['created_at']; ?></td>
                        <td><?php echo $log['user_message']; ?></td>
                        <td><?php echo $log['bot_response']; ?></td>
                        <td><strong><?php echo $log['detected_tag']; ?></strong></td>
                        <td><?php echo number_format($log['confidence'] * 100, 2, ',', '.') ?>%</td>
                    </tr>
                    <?php endforeach; ?>                    
                <?php else: ?>
                    <tr>
                        <td colspan="5">
                            No hay registros de chat todavía.
                        </td>
                    </tr>
                <?php endif; ?>                                
            </tbody>
        </table>
    </div>    
</section>

<?php
$page->do_html_footer();
?>
